<div class="row" id="newUser" >
    <form v-on:submit.prevent="addNewUser" autocomplete="off" >
        <div class="col-lg-12 mb-3">
             <label for="username">User Type</label>
             <select v-model="newuser.type" class="form-control"  required>
                <option value=""> - Choose User type - </option>
                <option v-for="(usertype,code) in type" :key="code" :value="code"> @{{ usertype }}</option>
             </select>
        </div>
        <div class="col-lg-12 mb-3">
             <label for="username">Username</label>
             <input type="text" name="username" v-model="newuser.username" class="form-control" required >
        </div>
        <div class="col-lg-12 mb-3">
             <label for="email">Email</label>
             <input type="text" name="email" v-model="newuser.email" class="form-control" @keyup="isvalidEmail" required>
             <p class="text-danger" v-show="emailError">Please input a valid email</p>
        </div>
        <div class="col-lg-12 mb-3">
             <label for="npassword">New Password</label>
             <input type="password" name="npassword" v-model="newuser.npassword" class="form-control" required>
        </div>
        <div class="col-lg-12 mb-3">
             <label for="cpassword">Confirm Password</label>
             <input type="password" name="cpassword" v-model="newuser.cpassword" class="form-control" required>
        </div>
        <div class="col-lg-12">
             <button class="btn btn-primary form-control" type="submit" :disabled="!canUpdatePass " >SAVE ACCOUNT</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function(){
    createApp({
        data(){
            return{
                newuser:{
                    type:"",
                    username:"",
                    email:"",
                    npassword:"",
                    cpassword:""
                },
                emailError:false
            }
        },
        created(){
            this.type = @json($userTypeList);
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        },
        methods:{
            isvalidEmail(){
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
                if(this.newuser.email !== ''){
                    if (!regex.test(this.newuser.email)) this.emailError = true;
                    else this.emailError = false
                }
                
            },
            async addNewUser(){
                const response = await fetch("{{ url('admin/accounts/addNew') }}",{
                    method:"POST",
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Content-Type': 'application/json'
                    },
                    body:JSON.stringify(this.newuser)
                });
                const result = await response.json()
                if(result){
                     Swal.fire({
                        icon: result.status > 0 ? 'success' :'error',
                        text: result.message
                    }).then( (res) => {
                        if(result.status > 0){
                            this.resetFields();
                        }
                    });
                }
            },
            resetFields(){
                this.newuser = {
                    type:"",
                    username:"",
                    email:"",
                    npassword:"",
                    cpassword:""
                }
            }
        },
        computed: {
            canUpdatePass() {
                if( ( this.newuser.npassword !== this.newuser.cpassword ) || ( this.emailError || this.newuser.email === "" ) || this.newuser.type === "" ) return false;

                else return true;
            }
        }
    }).mount("#newUser");
})
</script>