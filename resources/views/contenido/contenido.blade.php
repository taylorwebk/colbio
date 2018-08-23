@extends('principal')
@section('contenido')

@if(Auth::check())
        @if(Auth::user()->idrol==1) <!--rol 1 = administrador-->

        <template v-if="menu==0">
            <div class="container-fluid"><h2>Pagina de inicio</h2><div>
        </template>
        <template v-if="menu==1">
            <afiliado></afiliado>
        </template>
        <template v-if="menu==2">
        </template>
        <template v-if="menu==3">
            <aportes></aportes>
        </template>
        <template v-if="menu==4">
            <div class="container-fluid"><h2>Pagina sin diseñar</h2><div>
        </template>
        <template v-if="menu==5">
            <div class="container-fluid"><h2>Pagina sin diseñar</h2><div>
        </template>
        <template v-if="menu==6">
            <div class="container-fluid"><h2>Pagina sin diseñar</h2><div>
        </template>
        <template v-if="menu==7">
            <div class="container-fluid"><h2>Pagina sin diseñar</h2><div>
        </template>
        <template v-if="menu==8">
            <rol></rol>
        </template>
        <template v-if="menu==9">
            <reporte></reporte>
        </template>
        <template v-if="menu==10">
            <div class="container-fluid"><h2>Pagina sin diseñar</h2><div>
        </template>
        <template v-if="menu==11">
            <div class="container-fluid"><h2>Pagina sin diseñar</h2><div>
        </template>
        <template v-if="menu==12">
            <div class="container-fluid"><h2>Pagina sin diseñar</h2><div>
        </template>

        @elseif (Auth::user()->idrol==2) <!--rol 2 = afiliado-->
        <template v-if="menu==1">
            <afiliado></afiliado>
        </template>
        @else
        @endif
    @endif

@endsection