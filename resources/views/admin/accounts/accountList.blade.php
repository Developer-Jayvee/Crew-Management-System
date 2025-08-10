@extends('layouts.template')
@section('title', 'Accounts')
@section('content')

<div class="row" id="accountList">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">User Accounts</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-success" @click="addUser"> Add User Account </button>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(users,num) in userList" :key="users.username" :data-user="users.username">
                                        <td>@{{ num + 1 }}</td>
                                        <td>@{{ users.username }}</td>
                                        <td>@{{ users.email }}</td>
                                        <td>@{{ users.usertype }}</td>
                                        <td>
                                            <div class="">
                                                <button class="btn btn-success mx-2" @click="updateUser(users.username)"><i class="fa-solid fa-user-pen"></i></button>
                                                <button class="btn btn-danger" @click="deleteUser(users.username)"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    const globalModal = $("#global-modal");
    createApp({
        data(){
            return{
                userList:@json($userList),
                csrfToken: document.querySelector('meta[name="csrf-token"]').content,
            }
        },
        methods:{
            async deleteUser(username){
                  Swal.fire({
                        title: "Are you sure you want to proceed?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Proceed"
                    }).then(async (res) => {
                        if(res.isConfirmed){
                            const response = await fetch(
                                    "{{ url('admin/accounts') }}" + '/' + username, {
                                        method: "DELETE",
                                        headers: {
                                            'X-CSRF-TOKEN': this.csrfToken,
                                            'Content-Type': 'application/json'
                                        }
                                    });
                            const result = await response.json();
                            if(result){
                                location.reload();
                                // this.userList = this.userList.filter( user => user.username !== username );
                            }
                        }
                    });
            },
            async updateUser(username){
                const response = await fetch( "{{ url('admin/accounts') }}" + '/' + username);
                const result = await response.text();
                if(result){
                    globalModal.addClass('modal-md');
                    globalModal.find('.modal-title').text('Update User Account');
                    globalModal.find('.modal-body').html(result);
                    globalModal.modal('show');
                }
              
            },
            async addUser(){
                const response = await fetch( "{{ url('admin/newaccountSetup') }}");
                const result = await response.text();
                if(result){
                    globalModal.addClass('modal-md');
                    globalModal.find('.modal-title').text('Add New User Account');
                    globalModal.find('.modal-body').html(result);
                    globalModal.modal('show');
                }
            }
        }
    }).mount("#accountList");
});
</script>
@endsection