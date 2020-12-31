<div class="container mt-5">
    <table class="table mt-4" id="role-table">
        <thead>
        <th>posted by</th>
        <th>title</th>
        <th>description</th>
        </thead>
        {{$i=1}}
        @foreach($postsmail as $postmail)
            <th>{{$postmail->posted_by}}</th>
            <th>{{$postmail->title}}</th>
            <th>{{$postmail->description}}</th>
        @endforeach
    </table>
</div>
