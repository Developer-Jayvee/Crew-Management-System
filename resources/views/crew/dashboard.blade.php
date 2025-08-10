@extends('layouts.template')
@section('title', 'Accounts')
@section('content')

    <div class="row" id="dashboard">
        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body text-center">
                    @include("crew.profile")
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-header">Documents</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="text-danger fst-italic"><strong>Note:</strong>Please submit the following documents on the list:</p>
                        </div>
                        <form v-on:submit.prevent="uploadDocument" class="mb-3">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3" >
                                    <label for="documents">File*</label>
                                    <input class="form-control" type="file" id="document" @change="handleFileUpload"
                                    accept=".pdf,application/pdf" required>
                                </div>
                                <div class=" col-sm-6 col-md-6 col-lg-3 col-xl-3" >
                                    <label for="documents">Document*</label>
                                    <select v-model="document.contenttype" name="documents" class="form-control">
                                        <option value="" selected>- Choose a document -</option>
                                        <option v-for="(docs,code) in docList" :key="code" :value="code">
                                            @{{ docs }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-6  col-md-6 col-lg-3 col-xl-3">
                                    <label for="expirydate">Expiration Date</label>
                                    <input type="date" name="expirydate" v-model="document.expirydate" class="form-control">
                                </div>
                                <div class=" col-sm-3 col-md-3 col-lg-3 col-xl-2 ">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" class="btn btn-success form-control">SUBMIT</button>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-1 col-xl-2">&nbsp;</div>
                            </div>
                        </form>
                        <div class="col-lg-12">
                            <div class="table-responseive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Document</th>
                                            <th>Name</th>
                                            <th>Date Issued</th>
                                            <th>Date Expiry</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="user.userprofile.document_submitted.length == 0">
                                            <td colspan="6" class="text-center fst-italic">No Document Submitted.
                                            </td>
                                        </tr>
                                        <tr v-for="(docs,index) in user.userprofile.document_submitted" :key="docs.FileID">
                                            <td>@{{ index + 1 }}</td>
                                            <td>@{{ remainingDocument[docs.Code] || "" }}</td>
                                            <td><a href="#" style="color:blue;" title="View Document" @click="viewPDFFile(docs.FileID)" > @{{ docs.DocName }}</a></td>
                                            <td>@{{ docs.IssuedDate }}</td>
                                            <td>@{{ docs.ExpirationDate }}</td>
                                            <td>
                                                <button class="btn btn-danger" @click="deleteDocument(docs.ID)"><i class="fa fa-trash"></i></button>
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
                const user = @json($user);
                return {
                    docList:@json($docList),
                    remainingDocument:@json($remainingDocument),
                    files : @json($fileData),
                    bmi:this.calculateBMI(user.userprofile.Weight,user.userprofile.Height),
                    document:{
                        docSubmitted:"",
                        expirydate:"",
                        contenttype:""
                    }
                }
            },
            created(){
                this.user = @json($user);
                this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            },
            methods:{
                calculateBMI(weight, height) {
                    if (!weight || !height) return "";
                    const heightInMeters = height / 100;
                    return (weight / (heightInMeters * heightInMeters)).toFixed(1);
                },
                handleFileUpload(event) {
                        this.document.docSubmitted = event.target.files[0];
                },
                viewPDFFile(fileID){
                    if(this.files[fileID] === undefined){
                        Swal.fire({
                            text: 'No file found.',
                            icon: 'error',
                        });
                        return;
                    }

                    const fileData = this.files[fileID] ;
                    window.open(`data:application/pdf;base64,${fileData.data}`, '_blank','width=800,height=600');
                },
                async deleteDocument(fileID){
                      Swal.fire({
                            title: "Are you sure you want to proceed?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Proceed"
                        }).then(async (res) => {
                            if(res.isConfirmed){
                                const response = await fetch("{{ url('crew/document') }}" + '/' + fileID , {
                                    method: "DELETE",
                                    headers: {
                                        'X-CSRF-TOKEN': this.csrfToken,
                                        'Content-Type': 'application/json'
                                    }
                                });
                                const result = await response.json();
                                if(result){
                                    showToast(result.message,result.status);
                                    location.reload();
                                }
                            }
                        })
                    
                },
                async uploadDocument() {
                      
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
                        formData.append("userid", this.user.userprofile.ID);
                        formData.append("expirationDate", this.document.expirydate);
                        formData.append('documentType', this.document.contenttype);

                        try {
                            const response = await fetch("{{ route('crew/upload') }}", {
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
                                   location.reload();
                                });
                            }

                        } catch (err) {}
                    },
            }
        }).mount("#dashboard");
    });
</script>

@endsection
