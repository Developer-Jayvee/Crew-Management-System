@extends('layouts.template')
@section('title', 'Accounts')
@section('content')

    <div class="row" id="staffCrewList">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Crew List</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <input type="search" placeholder="Search..." class="form-control" style="width:30%;" v-model="searchcrew" @keyup="handleSearch">
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th><th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(crew, index) in crewList" :key="crew.fullname">
                                            <tr class="">
                                                <td colspan="7" class="px-4 border-bottom-0  pb-3">@{{ crew.fullname }} - @{{ crew.rank }}</td>
                                            </tr>
                                            <tr v-for="(doc,docIndex) in crew.documents" :key="docIndex">
                                                <td>@{{ docIndex + 1 }}</td>
                                                <td><a href="#" @click="viewPDF(doc.fileData)" style="color:blue;text-decoration:underline;" >@{{ doc.name }} </a></td>
                                                <td>@{{ doc.type }}</td>
                                                <td>@{{ doc.issued }}</td>
                                                <td>@{{ doc.expiry }} </td>
                                            </tr> 
                                            <tr v-if="crew.documents.length === 0">
                                                <td colspan="6" class="text-center fst-italic">No document found.</td>
                                            </tr>

                                        </template>
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
                    crewList: @json($crew),
                    searchcrew:""
                }
            },
            created(){
                this.temp = @json($crew);
            },
            methods:{
                viewPDF(fileData){
                    window.open(`data:application/pdf;base64,${fileData}`, '_blank','width=800,height=600');
                },
                handleSearch(){
                    this.crewList = this.temp; 
                    const query = this.searchcrew.toLowerCase();
                    this.crewList = this.crewList.filter(item => 
                        item.fullname.toLowerCase().includes(query) ||
                        item.rank.toLowerCase().includes(query) 
                    );
                       
                },
            }
        }).mount("#staffCrewList");

    })
</script>
@endsection
