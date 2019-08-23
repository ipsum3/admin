@extends('IpsumAdmin::errors.layout')

{{-- TODO traduction des pages d'erreurs --}}
@section('title', __('Page Not Found'))
@section('code', '404')
@section('message', __('Page Not Found'))
