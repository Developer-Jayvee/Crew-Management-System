<div class="row" id="updatesetup">
    <form v-on:submit.prevent="updateAccount" autocomplete="off">
        <div class="col-lg-12 mb-3">
             <label for="username">Username</label>
             <input type="text" name="username" v-model="userdetails.username" class="form-control" readonly>
        </div>
        <div class="col-lg-12 mb-3">
             <label for="email">Email</label>
             <input type="text" name="email" v-model="userdetails.email" class="form-control" @keyup="isvalidEmail">
            <p class="text-danger" v-show="emailError">Please input a valid email</p>
        </div>
        <div class="col-lg-12 mb-3">
             <label for="currentpass">Current Password</label>
             <input type="password" name="currentpass" v-model="userdetails.currentpass" class="form-control">
        </div>
        <div class="col-lg-12 mb-3">
             <label for="npassword">New Password</label>
             <input type="password" name="npassword" v-model="userdetails.npassword" class="form-control">
        </div>
        <div class="col-lg-12 mb-3">
             <label for="cpassword">Confirm Password</label>
             <input type="password" name="cpassword" v-model="userdetails.cpassword" class="form-control">
        </div>
        <div class="col-lg-12">
             <button class="btn btn-primary form-control" type="submit" :disabled="!canUpdatePass || !wrongCurrentPass">UPDATE ACCOUNT</button>
        </div>
    </form>
</div>
<script>
$(document).ready(function(){
    const userlistTable = $("#accountList").find('table > tbody');
    const useracc = @json($useracc);
    createApp({
        data(){
            return{
                csrfToken: document.querySelector('meta[name="csrf-token"]').content,
                userdetails : {
                    username:useracc.Username || "",
                    email:useracc.Email || "",
                    currentpass: "",
                    npassword:"",
                    cpassword:"",
                },
                wrongCurrentPass:true,
                emailError:false
            };
        },
        methods:{
            isvalidEmail(){
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
                if(this.userdetails.email !== ''){
                    if (!regex.test(this.userdetails.email)) this.emailError = true;
                    else this.emailError = false
                }
                
            },
            async updateAccount(){
                const response = await fetch(
                    "{{ url('admin/accounts/update') }}" , {
                        method: "PUT",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN':  this.csrfToken
                        },
                        body: JSON.stringify({ username: this.userdetails.username , email: this.userdetails.email , current : this.userdetails.currentpass , new : this.userdetails.npassword })
                    });
                const result = await response.json();
                if(result){
                    Swal.fire({
                        icon: result.status > 0 ? 'success' :'error',
                        text: result.message
                    }).then( (res) => {
                        this.userdetails.currentpass = "";
                        this.userdetails.npassword = "";
                        this.userdetails.cpassword = "";
                        userlistTable.find(`[data-user="${useracc.Username}"]`).find(':eq(2)').text(this.userdetails.email);

                    });
                }
            },
            
        },
        computed: {
            canUpdatePass() {
                if( ( this.userdetails.npassword !== this.userdetails.cpassword ) || ( this.emailError || this.userdetails.email === "" ) ) return false;
                else return true;
            }
        }
    }).mount("#updatesetup");
});
</script>