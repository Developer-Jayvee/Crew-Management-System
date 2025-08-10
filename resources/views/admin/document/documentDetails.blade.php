

<div class="table-responsive" id="docDetails">
    <table class="table">
        <thead>
            <th>Code</th>
            <th>Document Name</th>
            <th class="text-center">Document No.</th>
            <th>Issued Date</th>
            <th>Expiry Date</th>
            <th>Uploaded By<th>
        </thead>
        <tbody>
            <tr >
                <td >@{{ fileData.Code }}</td>
                <td><a href="#" @click="viewPDFFIles" style="color:blue;text-decoration:underline;" >@{{ fileData.Name }}</a></td>
                <td class="text-center">@{{ fileData.Count }}</td>
                <td>@{{ new Date(fileData.Issued).toDateString() }}</td>
                <td>@{{ new Date(fileData.Expiry).toDateString()   }}</td>
                <td>@{{ fileData.UploadedBy }}</td>
            </tr>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function(){
    createApp({
        data(){
            return {
                
                fileData:@json($fileData)
            }
        },
        methods:{
            viewPDFFIles(){
                const fileData = JSON.parse(this.fileData.file);
                window.open(`data:application/pdf;base64,${fileData}`, '_blank','width=800,height=600');
            }
        }
    }).mount("#docDetails");

});
</script>


