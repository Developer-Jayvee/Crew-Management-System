@extends('layouts.template')
@section('title', 'Crew List')
@section('content')

    <div class="row m-3 " id="crewList">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            Crew List
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    {{-- <label for="filterrank">Rank</label> --}}
                                                    <select v-model="filterrank" class="form-control" @change="filterByRank">
                                                        <option v-for="(rank,code) in rankList" :key="code" :value="code">
                                                            @{{ rank }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">&nbsp;</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 d-flex justify-content-end">
                                            {{-- <label for="searchcrew">&nbsp;s</label> --}}
                                            <input class="form-control" type="search" placeholder="Search" aria-label="Search" v-model="searchcrew" @keyup="handleSearch">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                     <div class="table-responsive h-100" style="max-height: 350px; overflow-y:auto;">
                                        <table class="table table-hover">
                                            <thead class="text-center sticky-top bg-white">
                                                <tr>
                                                    <th class="text-left" @click="sort('name')">Name  <span v-if="sortKey === 'name'">@{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                                                    <th class="text-left"  @click="sort('rank')">Rank <span v-if="sortKey === 'rank'">@{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                                                    <th class="text-left"  @click="sort('email')">Email <span v-if="sortKey === 'email'">@{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-group-divider text-left">
                                                <tr @click="viewprofile(crew)" v-for="crew in crewList" :key="crew.id">
                                                    <th>@{{ crew.name }} </th>
                                                    <th>@{{ crew.rank }} </th>
                                                    <th>@{{ crew.email }} </th>
                                                    <th>
                                                        <button class="btn btn-danger" @click="deleteCrew(crew.id)"><i class="fa fa-trash"></i></button>
                                                    </th>
                                                </tr>
                                                
                                                
                                            </tbody>
                                        </table>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row  ">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">Profile</div>
                                <div class="card-body text-center">
                                    <div id="profile-details px-3 text">
                                        
                                        <div class="row">
                                            <div class="col-lg-4 fw-bold" v-if="profile.lname">@{{ profile.lname }}</div>
                                            <div class="col-lg-4 fw-bold" v-if="profile.fname">@{{ profile.fname }}</div>
                                            <div class="col-lg-4 fw-bold" v-if="profile.mname">@{{ profile.mname }}</div>
                                        </div>
                                        <div class="row  fst-italic">
                                            <div class="col-lg-4 border-top">Last</div>
                                            <div class="col-lg-4 border-top">First</div>
                                            <div class="col-lg-4 border-top">Middle</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p class="text-left fw-bolder ">&nbsp;</p>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-9 fw-bold" v-if="profile.bdate">@{{ profile.bdate }}</div>
                                            <div class="col-lg-3 fw-bold" v-if="profile.age">@{{ profile.age }}</div>
                                        </div>

                                        <div class="row pt-0 mt-0 fst-italic ">
                                            <div class="col-lg-9  border-top ">Birthdate</div>
                                            <div class="col-lg-3 border-top">Age</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p class="text-left fw-bolder ">&nbsp;</p>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-lg-4 fw-bold" v-if="profile.weight">@{{ profile.weight }}</div>
                                            <div class="col-lg-4 fw-bold" v-if="profile.height">@{{ profile.height }}</div>
                                            <div class="col-lg-4 fw-bold" v-if="profile.bmi">@{{ profile.bmi }}</div>
                                        </div>

                                        <div class="row pt-0 mt-0 fst-italic ">
                                            <div class="col-lg-4 border-top">Weight</div>
                                            <div class="col-lg-4 border-top">Height</div>
                                            <div class="col-lg-4 border-top">BMI</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p class="text-left fw-bolder ">&nbsp;</p>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-12 fw-bold" v-if="profile.rank">@{{ profile.rank }}</div>
                                        </div>

                                        <div class="row pt-0 mt-0 fst-italic ">
                                            <div class="col-lg-12 border-top ">Rank</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p class="text-left fw-bolder ">&nbsp;</p>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-12 fw-bold" v-if="profile.address">@{{ profile.address }}
                                            </div>
                                        </div>

                                        <div class="row pt-0 mt-0 fst-italic ">
                                            <div class="col-lg-12 border-top ">Address</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 flex-grow-1">
                            <div class="card">
                                <div class="card-header">
                                    Document Submitted
                                </div>
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".modal"
                                                :data-user-id="userid" :disabled="profile.fname == '' "> Add Document</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-1 ">
                                        <div class="table-responsive h-100" style="max-height: 250px; overflow-y:auto;">
                                            <table class="table table-hover">
                                                <thead class="text-center sticky-top bg-white">
                                                    <tr>
                                                        <th>Document</th>
                                                        <th>Issued Date</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="docs in profile.documents" :key="docs.fileID" :class="calculateExpirationDate(docs.issuedDate,docs.expiryDate)" >
                                                        <td @click="openPDFModal(docs.fileID)">@{{ docs.description }}</td>
                                                        <td class="text-center" @click="openPDFModal(docs.fileID)">@{{ docs.issuedDate }}</td>
                                                        <td>
                                                            <button class="btn btn-danger"
                                                                @click="deleteDocument(docs.fileID)"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="profile.documents.length == 0">
                                                        <td colspan="3" class="text-center fst-italic">No data found.
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

            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form v-on:submit.prevent="uploadDocument" ref="uploadForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <select name="contenttype" class="form-select" v-model="document.contenttype"
                                        required>
                                        <option v-for="(doc,code) in docList" :key="code"
                                            :value="code">
                                            @{{ doc }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <input class="form-control" type="file" id="document" @change="handleFileUpload"
                                        accept=".pdf,application/pdf" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="formFile" class="form-label">Expiry Date</label>
                                    <input type="date" name="expirationDate" class="form-control"
                                        v-model="document.expirationDate">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            createApp({
                data() {
                    return {
                        crewList: @json($crewList),
                        tempCrewList: [],
                        docList: @json($docList),
                        csrfToken: document.querySelector('meta[name="csrf-token"]').content,
                        userid: "",
                        searchcrew:"",
                        filterrank:"",
                        sortKey: 'name',
                        sortOrder: 'asc',
                        profile: {
                            lname: "",
                            fname: "",
                            mname: "",
                            address: "",
                            rank: "",
                            weight: "",
                            height: "",
                            age: "",
                            bdate: "",
                            bmi: "",
                            id: "",
                            documents: ""
                        },
                        document: {
                            contenttype: "",
                            docSubmitted: "",
                            expirationDate: "",
                            issuedDate: ""
                        },

                    }
                },
                 created() {
                    this.tempCrewList = [...this.crewList];
                    this.rankList = @json($rankList);
                },
                methods: {
                    viewprofile(details) {
                        this.profile = {
                            lname: details.last || "",
                            fname: details.first || "",
                            mname: details.middle || "",
                            address: details.address || "",
                            rank: details.rank || "",
                            weight: details.weight || "",
                            height: details.height || "",
                            age: details.age || "",
                            bdate: details.bdate || "",
                            bmi: this.calculateBMI(details.weight, details.height) || "",
                            id: details.id,
                            documents: JSON.parse(details.docs) || ""
                        };


                    },
                    async deleteCrew(data){
                          Swal.fire({
                            title: "Are you sure you want to proceed?",
                            text:"This will remove all users data and documents",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Proceed"
                        }).then(async (res) => {

                            if(res.isConfirmed){
                                const response = await fetch(
                                   "{{ url('admin/crewlist') }}" + '/' + data, {
                                       method: "DELETE",
                                       headers: {
                                           'X-CSRF-TOKEN': this.csrfToken,
                                           'Content-Type': 'application/json'
                                       }
                                   });
                               const result = await response.json();
                               if(result){
                                   this.crewList = this.crewList.filter( crew => crew.id !== data );
                                   this.tempCrewList = this.tempCrewList.filter( crew => crew.id !== data );
                                    this.resetFields();
                                    Swal.fire({
                                        text:result.message,
                                        icon:result.status > 0 ? 'success': "warning",
                                    });
                                   
                               }
                            }

                        });
                    },
                    calculateBMI(weight, height) {
                        if (!weight || !height) return "";
                        const heightInMeters = height / 100;
                        return (weight / (heightInMeters * heightInMeters)).toFixed(1);
                    },
                    async uploadDocument() {
                        console.log(this.document.docSubmitted);
                      
                        if (!this.document.docSubmitted) {
                            Swal.fire({
                                icon: 'error',
                                text: 'Please select a file'
                            });
                            return;
                        }
                        if(this.document.docSubmitted.type != 'application/pdf'){
                             Swal.fire({
                                icon: 'error',
                                text: 'Please upload pdf file only.'
                            });
                            return;
                        }
                        const formData = new FormData();
                        formData.append("document", this.document.docSubmitted);
                        formData.append("userid", this.profile.id);
                        formData.append("expirationDate", this.document.expirationDate);
                        formData.append('documentType', this.document.contenttype);

                        try {
                            const response = await fetch("{{ url('admin/uploadDoc') }}", {
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken,
                                },
                                body: formData,
                            });

                            if (!response.ok) throw new Error("Upload failed");

                            const result = await response.json();
                            if (result) {
                                Swal.fire({
                                    text: result.message,
                                    icon: 'success',
                                }).then((res) => {
                                    this.crewList = this.crewList.map(crew => {
                                        if (crew.id !== this.profile.id) return {
                                            ...crew
                                        };
                                        const updatedCrew = {
                                            ...crew
                                        };
                                        const documents = crew.docs ? JSON.parse(crew
                                            .docs) : [];

                                        documents.push(JSON.parse(result.data));

                                        updatedCrew.docs = JSON.stringify(documents);

                                        return updatedCrew;
                                    });


                                    this.document = {
                                        contenttype: "",
                                        docSubmitted: null,
                                        expirationDate: "",
                                        // issuedDate: ""
                                    };
                                    this.$refs.uploadForm?.reset();

                                    this.viewprofile(this.crewList.find(c => c.id === this
                                        .profile.id));
                                })
                            }

                        } catch (err) {}
                    },
                    async deleteDocument(data) {

                        Swal.fire({
                            title: "Are you sure you want to proceed?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Proceed"
                        }).then(async (result) => {
                            if (result.isConfirmed) {
                                const response = await fetch(
                                    "{{ url('admin/deleteFile') }}" + '/' + data, {
                                        method: "DELETE",
                                        headers: {
                                            'X-CSRF-TOKEN': this.csrfToken,
                                            'Content-Type': 'application/json'
                                        }
                                    });
                                const result = await response.json();
                                if (result) {
                                    Swal.fire({
                                        text: result.message,
                                        icon: 'success',
                                    }).then((res) => {
                                        this.profile.documents = this.profile
                                            .documents.filter(
                                                doc => doc.fileID !== data
                                            );
                                        this.crewList = this.crewList.map(crew => {
                                            if (crew.docs) {
                                                const updatedDocs = JSON
                                                    .parse(crew.docs);

                                                const filteredDocs =
                                                    updatedDocs.filter(
                                                        doc => doc
                                                        .fileID !== data);
                                                crew.docs = JSON.stringify(
                                                    filteredDocs);
                                            }
                                            return crew;
                                        });
                                    });
                                }
                            }
                        });
                    },
                    handleFileUpload(event) {
                        this.document.docSubmitted = event.target.files[0];
                    },
                    async openPDFModal(data) {
                        const modal = $("#global-modal");
                        modal.addClass('modal-xl')
                        modal.find('#modal-title').text('');

                        const response = await fetch("{{ url('admin/documentDetails') }}" + '/' + data);
                        const result = await response.text();
                        if (result) modal.find('.modal-body').html(result);

                        modal.modal('show');


                    },
                    calculateExpirationDate(issueddate,expdate) {
                        const docDate = new Date(expdate);
                        const issued = new Date(issueddate);
                        const diffTime = Math.abs(issued - docDate);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        if (diffDays <= 7) return 'red-document';
                        else if (diffDays <= 30)  return 'yellow-document';
                        else if(diffDays <= 90) return 'orange-document';
                        else if(diffDays >  90)  return ''
                    },
                    handleSearch(){
                        this.crewList = this.tempCrewList; 
                        const query = this.searchcrew.toLowerCase();
                        this.crewList = this.crewList.filter(item => 
                            item.name.toLowerCase().includes(query) ||
                            item.rank.toLowerCase().includes(query) 
                        );
                       
                    },
                    filterByRank(event){
                        this.crewList = this.tempCrewList; 
                        this.crewList = this.crewList.filter(item => 
                            item.rankCode.includes(this.filterrank) 
                        );
                       
                    },
                    resetFields(){
                        this.profile = {
                            lname: "",
                            fname: "",
                            mname: "",
                            address: "",
                            rank: "",
                            weight: "",
                            height: "",
                            age: "",
                            bdate: "",
                            bmi: "",
                            id: "",
                            documents: ""
                        };
                        this.document = {
                            contenttype: "",
                            docSubmitted: "",
                            expirationDate: "",
                            issuedDate: ""
                        };
                    },
                    sort(key){
                        if (this.sortKey === key) {
                            this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
                        } else {
                            this.sortKey = key;
                            this.sortOrder = 'asc';
                        }

                        this.crewList.sort((a, b) => {
                            const aValue = String(a[key]).toLowerCase();
                            const bValue = String(b[key]).toLowerCase();
                            
                            return this.sortOrder === 'desc' 
                                ? aValue.localeCompare(bValue)
                                : bValue.localeCompare(aValue);
                        });
                    }
                },
                
              

            }).mount("#crewList");
        });
    </script>




@endsection
