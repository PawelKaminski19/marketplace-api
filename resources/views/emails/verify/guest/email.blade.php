
@extends('emails/template')


@section('title')
    @isset($title)
        {{ $title }}
    @endisset
@endsection

@section('content')
    <h2>Confirm your Email address</h2>
    <p>Thank you for signing up. We’re happy you’re here!</p>
    <p>Please enter the following code in the window where you began creating your new account:</p>
    <table width="100%" bgcolor="#F1F1F1" style="border-radius: 4px;">
    	<tr>
    		<td>
    			<table align="center">
    				<tr>
    					<?php
    						$chars = str_split($token);
    	                    foreach($chars as $char){ ?>
            					<td align="center" style="padding: 5px;">
            						<h1> {{ $char }} </h1>
            					</td>
    					<?php } ?>
    				</tr>
    			</table>
    		</td>
    	</tr>
    </table>
    <p>Please note: This code can only be used once and will become inactive in {{ $expiration_minutes }} minutes.</p>
@endsection
