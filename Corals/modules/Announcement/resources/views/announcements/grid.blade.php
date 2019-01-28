@extends('layouts.crud.grid')

@section('css')
    <style>
        .announcement-item {
            height: 350px;
            max-height: 350px;
        }

        .announcement-image {
            width: 100%;
            height: 300px;
            background-position: left center;
            background-size: cover;
        }

        .announcement-item .badge-yellow {
            padding: 0.2em 0.8em;
            background-color: yellow;
            color: black;
        }

        .el-element-overlay .el-card-item .el-card-content a {
            color: #212529;
        }

        .el-element-overlay .el-card-item .el-card-content a:hover {
            color: #fb9678;
        }

        .el-overlay-1 {
            width: 100%;
            overflow: hidden;
            position: relative;
            text-align: center;
            cursor: default;
        }

        .el-overlay-1 .el-info {
            text-decoration: none;
            display: inline-block;
            text-transform: uppercase;
            color: #fff;
            background-color: transparent;
            filter: alpha(opacity=0);
            -webkit-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
            padding: 0;
            margin: auto;
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%) translateZ(0);
            -webkit-transform: translateY(-50%) translateZ(0);
            -ms-transform: translateY(-50%) translateZ(0);
        }

        .el-overlay-1 .el-info > li {
            list-style: none;
            display: inline-block;
            margin: 0 3px;
        }

        .el-overlay-1 .el-info > li a {
            border-color: #fff;
            color: #fff;
            padding: 12px 15px 10px;
        }

        .el-overlay-1 .el-info > li a:hover {
            background: #fb9678;
            border-color: #fb9678;
        }

        .el-overlay {
            width: 100%;
            height: 100%;
            position: absolute;
            overflow: hidden;
            top: 0;
            left: 0;
            opacity: 0;
            background-color: rgba(0, 0, 0, 0.7);
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
        }

        .el-overlay-1:hover .el-overlay {
            opacity: 1;
            filter: alpha(opacity=100);
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        }
    </style>
@endsection
@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('announcements') }}
        @endslot
    @endcomponent
@endsection