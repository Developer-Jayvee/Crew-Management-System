@extends('layouts.template2')
@section('title', 'Signup')
@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card" style="width: 40rem;">
            <div class="card-body">
                <h5 class="card-title text-center">Registration</h5>
                <form method="POST" action="{{ url('/signupuser') }}" id="signupForm" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <input type="text" class="form-control" id="fname" name="fname"
                                placeholder="First Name" required>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <input type="text" class="form-control" id="mname" name="mname"
                                placeholder="Middle Name">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name"
                                required>
                        </div>
                        <div class="col-lg-8 mb-3">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" v-model="email" @blur="isvalidEmail"
                                required>
                            <p class="text-danger" v-show="emailError">Please input a valid email</p>
                        </div>
                        <div class="col-lg-4  mb-3">
                            <input type="date" class="form-control" id="bdate" name="bdate" v-model="bdate"
                                required>
                        </div>
                        <div class="col-lg-4  mb-3">
                            <input type="text" class="form-control" id="age" name="age" placeholder="Age"
                                v-model="age" readonly>
                        </div>
                        <div class="col-lg-4  mb-3">
                            <input type="text" class="form-control" id="weight" name="weight" v-model="weight" @keypress="validateInteger"
                                placeholder="Weight (in kg)">
                        </div>
                        <div class="col-lg-4  mb-3">
                            <input type="text" class="form-control" id="height" name="height" v-model="height" @keypress="validateInteger"
                                placeholder="Height (in cm)">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <textarea name="address" id="address" class="form-control" style="resize: none;" placeholder="Address"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <select class="form-control" name="rank">
                                <option v-for="(rank,code) in ranks" :key="code" :value="code">
                                    @{{ rank }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control" id="username" name="username" max=10
                            placeholder="Username" @keypress="stringOnly($event,'username')" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            @keypress="stringOnly($event,'password')" v-model="pass" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="cpassword" name="cpassword"
                            placeholder="Confirm Password" @keypress="stringOnly($event,'password')" @blur="confirmPassword"
                            v-model="cpass" required>
                        <p class="text-danger" v-if="status == 'invalid'">Passwords do not match. Please re-enter your
                            password</p>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Signup</button>
                </form>
                <br>
                <p class='text-success text-center'>Already have an account ? <a href="{{ url('login') }}">Login</a></p>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const {
                createApp,
                ref
            } = Vue;
            createApp({
                data() {
                    return {
                        ranks: @json($rankList),
                        isDisabled: true,
                        cpass: "",
                        pass: "",
                        status: "valid",
                        bdate: "",
                        age: "",
                        email:"",
                        emailError:false,
                        weight:"",
                        height:""
                    }
                },
                methods: {
                    stringOnly(event, type) {
                        if (type == 'username') {
                            checkIfStringOnly(event, 10)
                        } else {
                            checkIfStringOnly(event, 20)
                        }
                    },
                    confirmPassword() {
                        if (this.pass !== this.cpass) {
                            this.status = 'invalid'
                        } else {
                            this.status = 'valid';
                        }
                    },
                    isvalidEmail(){
                        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
                        if(this.email !== ''){
                            if (!regex.test(this.email)) this.emailError = true;
                            else this.emailError = false
                        }
                        
                    },
                    validateInteger(event) {
                        const key = String.fromCharCode(event.keyCode || event.which);
                        if ([8, 9, 13, 27, 46].includes(event.keyCode) || 
                            (event.ctrlKey && [65, 67, 86, 88].includes(event.keyCode))) {
                            return;
                        }
                        
                        if (!/^\d$/.test(key)) {
                            event.preventDefault();
                        }
                    }
                },
                watch: {
                    bdate(date) {
                        const birthdate = new Date(date);
                        const today = new Date();
                        if (isNaN(birthdate.getTime())) {
                            this.age = 0;
                            return;
                        }

                        // Calculate age
                        let age = today.getFullYear() - birthdate.getFullYear();
                        const monthDiff = today.getMonth() - birthdate.getMonth();

                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                            age--;
                        }

                        this.age = age;

                    }
                }

            }).mount("#signupForm");
        });
    </script>


@endsection
