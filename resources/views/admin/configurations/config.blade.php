@extends('layouts.template')
@section('title', 'Configuration')
@section('content')
<div class="row m-3" id="configuration">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">Rank Setup</div>
                <div class="card-body">
                    <div class="row">
                        <form v-on:submit.prevent="submitSetupRank">
                            <div class="row">
                                <div class="col-lg-3 mb-1">
                                    <input type="text" name="rankcode" class="form-control" placeholder="Code" v-model="rank.rankcode" required />
                                </div>
                                <div class="col-lg-4 mb-1">
                                    <input type="text" name="rankdescription" class="form-control" placeholder="Description" v-model="rank.rankdescription" required />
                                </div>
                                <div class="col-lg-3 mb-1">
                                    <input type="text" name="rankalias" class="form-control" placeholder="Alias" v-model="rank.rankalias" required/>
                                </div>
                                <div class="col-lg-2 mb-1">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-success form-control">SUBMIT</button>
                                        </div>
                                        <div class="col-lg-6">
                                            <button class="btn btn-danger form-control" type="button" @click="clearField('rank')">CLEAR</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 mt-3">
                            <div class="table-responsive h-100" style="max-height: 350px; overflow-y:auto;">
                                <table class="table table-hover">
                                    <thead class="sticky-top bg-white">
                                        <tr>
                                            {{-- <th>#</th> --}}
                                            <th @click="sort('code','rank')">Code  <span v-if="sortKey === 'code' && sortSetup == 'rank'">@{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                                            <th @click="sort('description','rank')">Description <span v-if="sortKey === 'description' && sortSetup == 'rank' ">@{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                                            <th @click="sort('alias','rank')">Alias <span v-if="sortKey === 'alias' && sortSetup == 'rank' ">@{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(ranks,index) in rankList" :key="ranks.code" @click="update(ranks,'rank')">
                                            {{-- <td>@{{ index + 1 }}</td> --}}
                                            <td>@{{ ranks.code }}</td>
                                            <td>@{{ ranks.description }}</td>
                                            <td>@{{ ranks.alias }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button @click="deleteRank(ranks.code)"><i class="fa fa-trash"></i></button>
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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Document Setup</div>
                <div class="card-body">
                    <div class="row">
                        <form v-on:submit.prevent="submitSetupDocument">
                            <div class="row">
                                <div class="col-lg-3 mb-1">
                                    <input type="text" name="doccode" class="form-control" placeholder="Code" v-model="document.doccode" required>
                                </div>
                                <div class="col-lg-5 mb-1">
                                    <input type="text" name="docdescription" class="form-control" placeholder="Description" v-model="document.docdescription" required>
                                </div>
                                <div class="col-lg-4 mb-1">
                                   <div class="row">
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-success form-control">SUBMIT</button>
                                        </div>
                                        <div class="col-lg-6">
                                            <button class="btn btn-danger form-control" type="button" @click="clearField('document')">CLEAR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="col-lg-12 mt-3">
                           <div class="table-responsive h-100" style="max-height: 150px; overflow-y:auto;">
                                <table class="table table-hover">
                                    <thead class="sticky-top bg-white">
                                        <tr>
                                            {{-- <th>#</th> --}}
                                            <th @click="sort('code','document')">Code <span v-if="sortKey === 'code' && sortSetup == 'document'">@{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                                            <th @click="sort('description','document')">Description  <span v-if="sortKey === 'description' && sortSetup == 'document'">@{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr v-for="(docs,index) in documentList" :key="docs.code" @click="update(docs,'document')">
                                            {{-- <td>@{{ index + 1 }}</td> --}}
                                            <td>@{{ docs.code }}</td>
                                            <td>@{{ docs.description }}</td>
                                            <td @click="">
                                                <div class="btn-group">
                                                    <button @click="deleteDocument(docs.code)"><i class="fa fa-trash"></i></button>
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
        <div class="col-lg-6 ">
            <div class="card">
                <div class="card-header">User Type Setup</div>
                <div class="card-body">
                    <div class="row">
                        <form v-on:submit.prevent="submitUserType" ref="userTypeForm">
                            <div class="row">
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" v-model="user.code" placeholder="Code" required>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" v-model="user.type" placeholder="Description" required>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-success form-control">SUBMIT</button>
                                        </div>
                                        <div class="col-lg-6">
                                            <button class="btn btn-danger form-control" type="button" @click="clearField('usertype')">CLEAR</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="col-lg-12 mt-3">
                           <div class="table-responsive h-100" style="max-height: 150px; overflow-y:auto;">
                                <table class="table table-hover">
                                    <thead class="sticky-top bg-white">
                                        <tr>
                                            <th>Code</th>
                                            <th @click="sort('description','usertype')">User Type  <span v-if="sortKey === 'description' && sortSetup == 'usertype' ">@{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr v-for="(user,index) in userTypeList" :key="user.code">
                                            <td>@{{ user.code }}</td>
                                            <td>@{{ user.description }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button @click="deleteUserType(user.code)"><i class="fa fa-trash"></i></button>
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
   
    createApp({
        data(){
            return{
                rankList:@json($rankList),
                documentList:@json($documentList),
                userTypeList:@json($userTypeList),
                csrfToken: document.querySelector('meta[name="csrf-token"]').content,
                sortKey: 'name',
                sortOrder: 'asc',
                sortSetup : 'rank',
                rank:{
                    rankcode:"",
                    rankdescription:"",
                    rankalias:""
                },
                document:{
                    doccode:"",
                    docdescription:""
                },
                user:{
                    type:"",
                    code:""
                }
            }
        },
        methods:{
            update(data , setup){
                if(setup == 'document'){
                    this.document = {
                        doccode:data.code,
                        docdescription:data.description
                    }
                }else if(setup == 'rank'){
                    this.rank = {
                        rankcode:data.code,
                        rankdescription:data.description,
                        rankalias:data.alias
                    }
                }

            },
            clearField(setup){
                if(setup == 'document'){
                     this.document = {
                        doccode:"",
                        docdescription:""
                    }
                }
                else if(setup == 'rank'){
                    this.rank = {
                        rankcode:"",
                        rankdescription:"",
                        rankalias:""
                    }
                }else{
                    this.user = {
                        type:""
                    }
                }
            },
            async submitSetupRank(){
                const formData = new FormData();
                formData.append('code',this.rank.rankcode);
                formData.append('description',this.rank.rankdescription);
                formData.append('alias',this.rank.rankalias);
               
                
                const response = await fetch("{{ route('add/Rank') }}",{
                    method:"POST",
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                    },
                    body: formData,
                });
                const result = await response.json();

                if(result){
                    if(result.status > 0){
                        const codeExists = this.rankList.some(item => item.code === this.rank.rankcode);
                        if(!codeExists){
                            this.rankList = [...this.rankList, { 
                                code: this.rank.rankcode,
                                description: this.rank.rankdescription,
                                alias: this.rank.rankalias
                            }];
                        }
                    }
                    showToast(result.message,result.status);
                }
                this.rank = {
                    rankcode:"",
                    rankdescription:"",
                    rankalias:""
                }
                
            },
            async submitSetupDocument(){
                const formData = new FormData();
                formData.append('code',this.document.doccode);
                formData.append('description',this.document.docdescription);
               
                
                const response = await fetch("{{ route('add/Document') }}",{
                    method:"POST",
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                    },
                    body: formData,
                });
                const result = await response.json();

                if(result){
                    if(result.status > 0){
                        const codeExists = this.documentList.some(item => item.code === this.document.doccode);
                        if(!codeExists){
                            this.documentList = [...this.documentList, { 
                                code: this.document.doccode,
                                description: this.document.docdescription,
                            }];
                        }
                        showToast(result.message,result.status);
                    }
                }
                this.document = {
                    doccode:"",
                    docdescription:""
                }
            },
            async submitUserType(){
                const formData = new FormData();
                formData.append('description',this.user.type);
                formData.append('code',this.user.code);
                
                const response = await fetch("{{ route('add/UserType') }}",{
                    method:"POST",
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                    },
                    body: formData,
                });
                const result = await response.json();

                if(result){
                    if(result.status > 0){
                        const codeExists = this.userTypeList.some(item => item.description === this.user.type);
                        if(!codeExists){
                            this.userTypeList = [...this.userTypeList, { 
                                code :this.user.code,
                                description: this.user.type,
                            }];
                        }
                        showToast(result.message,result.status);
                    }
                }
                this.user.type = "";
            },
            async deleteRank(data){
                Swal.fire({
                    title: "Are you sure you want to proceed?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Proceed"
                }).then(async (res) => {
                    if(res.isConfirmed){
                        const response = await fetch(
                            "{{ url('admin/setup/rank') }}" + '/' + data, {
                                method: "DELETE",
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken,
                                    'Content-Type': 'application/json'
                                }
                            });
                        const result = await response.json();
                        if(result){
                            if(result.status > 0){
                                this.rankList = this.rankList.filter( rank => rank.code !== data );
                            }
                            showToast(result.message,result.status);
                        }
                    }
                });
            },
            async deleteDocument(data){
                 Swal.fire({
                    title: "Are you sure you want to proceed?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Proceed"
                }).then(async (res) => {
                    if(res.isConfirmed){
                        const response = await fetch(
                            "{{ url('admin/setup/document') }}" + '/' + data, {
                                method: "DELETE",
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken,
                                    'Content-Type': 'application/json'
                                }
                            });
                        const result = await response.json();
                        if(result){
                            if(result.status > 0){
                                this.documentList = this.documentList.filter( docs => docs.code !== data );
                            }
                            showToast(result.message,result.status);
                        }
                    }
                });
            },
            async deleteUserType(data){
                Swal.fire({
                    title: "Are you sure you want to proceed?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Proceed"
                }).then(async (res) => {
                    if(res.isConfirmed){

                        const response = await fetch(
                            "{{ url('admin/setup/usertype') }}" + '/' + data, {
                                method: "DELETE",
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken,
                                    'Content-Type': 'application/json'
                                }
                            });
                        const result = await response.json();
                        if(result){
                            if(result.status > 0){
                                this.userTypeList = this.userTypeList.filter( user => user.code !== data );
                            }
                            showToast(result.message,result.status);
                        }
                    }
                });
            },
            sort(key,config){
                if (this.sortKey === key) {
                    this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortKey = key;
                    this.sortOrder = 'asc';
                }
                let tempList = ""
                if(config == 'rank') tempList = [...this.rankList]; 
                else if (config == 'document') tempList = [...this.documentList];
                else if (config == 'usertype') tempList = [...this.userTypeList];
                this.sortSetup = config;

                tempList.sort((a, b) => {
                    const aValue = String(a[key]).toLowerCase();
                    const bValue = String(b[key]).toLowerCase();
                    if (!aValue && !bValue) return 0;
                    return this.sortOrder === 'desc' 
                        ? aValue.localeCompare(bValue)
                        : bValue.localeCompare(aValue);
                });
                
                if(config == 'rank')  this.rankList = tempList
                else if (config == 'document') this.documentList = tempList
                else if (config == 'usertype') this.userTypeList = tempList
                
            }
        }
    }).mount("#configuration");
});
</script>
@endsection
