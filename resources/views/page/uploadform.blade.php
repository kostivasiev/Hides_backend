<form action="{{ route('uploadFile') }}" method="post" enctype="multipart/form-data" class="my-4">
    @csrf

    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="userFile" name="userFile">
            <label class="custom-file-label" for="userFile">Choose a file</label>
		
        </div>
		
		<div class="custom-file">
			<input type="text" class="custom-file-input" id="userencryptcode" name="userencryptcode">
			<label class="custom-file-label" for="userFile">Put Encrypt Code here</label>
		</div>
    </div>

    <button type="submit" class="btn btn-primary">Upload</button>

    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</form>