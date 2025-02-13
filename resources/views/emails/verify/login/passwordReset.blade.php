
@extends('emails/template')


@section('title')
    @isset($title)
        {{ $title }}
    @endisset
@endsection

@section('content')
    <h2>Send a login link</h2>
   
    <p>Please use a link to log in to your account:</p>
    <table width="100%" bgcolor="#F1F1F1" style="border-radius: 4px;">
    	<tr>
    		<td>
    			<table align="center">
    				<tr>
						<td align="center" style="padding: 5px;">
							<h1> <a href="{{ $domain }}/l/password/reset/{{ $hash }}">Reset password</a></h1>
						</td>
    				</tr>
    			</table>
    		</td>
    	</tr>
    </table>
    <p>Please note: This code can only be used once and will become inactive in {{ $expiration_minutes }} minutes.</p>
@endsection
