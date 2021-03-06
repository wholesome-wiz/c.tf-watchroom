@extends('layouts.app')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row md-2">
				<div class="col-sm-6">
					<h1>Post</h1>
				</div>
				<div class="col-sm-6">
					<a
					href="{{route('posts.index')}}"
					class="btn btn-default float-right text-muted">Back</a>
				</div>
			</div>
		</div>
	</section>

	<div class="content px-3">
		<div class="card">
			<div class="card-body">
				<div class="mailbox-read-info">
					<h5>[{{$post->id}}] {{$post->title}}</h5>
					<h6>
						{{$post->author}}
						<span class="mailbox-read-time float-right">
							<div>Created: {{$post->created}}</div>
							<div>Published: {{$post->published}}</div>
						</span>
					</h6>
				</div>
				<div class="mailbox-read-message">
					@if($post->is_html==1)
						<?php
							$post->story = str_replace('{CDN}','/cdn',$post->story);
							$post->story = str_replace('"/','"//creators.tf/',$post->story);
							echo $post->story;
						?>
					@else
						{{ $post->story }}
					@endif
				</div>
			</div>
			<div class="card-footer row">
				<span class="col-1">
					<i class="fas fa-thumbs-up"></i>
					@if (isset($post->likes))
					{{ $post->likes }}
					@else
						0
					@endif
					{{$post->likes}}
				</span>
				<span class="col-1">
					<i class="fas fa-eye"></i>
					@if (isset($post->views))
						{{ $post->views }}
					@else
						0
					@endif
				</span>
			</div>
		</div>
	</div>
@endsection