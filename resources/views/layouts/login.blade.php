
@extends('layouts.template2')
@section('title', 'Login')
@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 24rem;">
        <div class="card-body">
            <h5 class="card-title text-center">Login</h5>
                @error('err')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ url('/loginuser')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" max=10 v-model="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" v-model="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" >Login</button>
                </form>
                <br>
                <p class='text-success text-center'>You don't have an account ? <a href="{{ url('signup') }}">Register Here</a></p>
            </div>
        </div>
    </div>






<script>
$(document).ready(function(){
    const {createApp , ref} = Vue;

    createApp({
        data(){
            return{
                username:"",
                password:""
            }
        }
    });
});
</script>

    
@endsection



