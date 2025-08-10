<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- CSS --}}
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
   
</head>
<body>


{{-- <div id="app">
  @{{ message }}
  <p v-if="status == 'active'">User is active </p>
  <p v-else-if="status === 'pending'">User is pending</p>
  <ul>
    <li v-for="(task, index) in tasks" :key="task">
        <span>
            @{{ task }}
        </span>
        <button @click="deleteTask(index)">x</button>
    </li>
  </ul>

   <button @click="toggeStatus">Toggle status</button>

   <form @submit.prevent="addTask">
    <label for="newTask">Add Task</label>
    <input type="text" name="newTask" id="newTask" v-model="newTask" />
    <button type="submit">submit</button>
</form>
</div> --}}


<div class="container">
    @yield('content')
</div>


<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
<script>
function checkIfStringOnly(event,max){
        const strRegex = /^[A-Za-z]$/;
        const charCode = event.keyCode || event.which;
        const charStr = String.fromCharCode(charCode);
        if (!strRegex.test(charStr)) {
            event.preventDefault();
        }
        if (event.target.value.length >= max) {
            event.preventDefault();
        }
}
</script>
</body>
</html>



