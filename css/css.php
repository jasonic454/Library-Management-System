<?php
/**
* This file contains additional CSS styling for the Library Management System
*/
?>

<style type='text/css'>

/* ── General body ── */
body {
    background-color: #f4f6f9;
    font-family: 'Helvetica Neue', Arial, sans-serif;
    color: #333;
}

/* ── Navbar ── */
.navbar-inverse {
    background-color: #2c3e50;
    border-color: #1a252f;
}
.navbar-inverse .navbar-brand {
    color: #ecf0f1;
    font-weight: bold;
    letter-spacing: 1px;
    font-size: 18px;
}
.navbar-inverse .navbar-nav > li > a {
    color: #bdc3c7;
    font-size: 14px;
    padding: 15px 14px;
}
.navbar-inverse .navbar-nav > li > a:hover {
    color: #ffffff;
    background-color: #1a252f;
}
.navbar-inverse .navbar-nav > .active > a,
.navbar-inverse .navbar-nav > .active > a:hover {
    background-color: #1abc9c;
    color: #fff;
}

/* ── Page panels ── */
.panel {
    border-radius: 6px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    border: none;
    margin-bottom: 20px;
}
.panel-heading {
    background-color: #2c3e50 !important;
    color: #ecf0f1 !important;
    border-radius: 6px 6px 0 0 !important;
    padding: 12px 16px;
}
.panel-heading h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #ecf0f1;
}
.panel-body {
    padding: 16px;
    background-color: #ffffff;
}

/* ── Tables ── */
.table {
    font-size: 13px;
}
.table > thead > tr > th {
    background-color: #2c3e50;
    color: #ecf0f1;
    border-bottom: none;
    padding: 10px 12px;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f9fafb;
}
.table > tbody > tr > td {
    padding: 8px 12px;
    vertical-align: middle;
}
.table > tbody > tr:hover {
    background-color: #eaf4fb;
}

/* ── Buttons ── */
.btn-default {
    background-color: #2c3e50;
    color: #fff;
    border-color: #1a252f;
    border-radius: 4px;
}
.btn-default:hover {
    background-color: #1abc9c;
    border-color: #1abc9c;
    color: #fff;
}
.btn-primary {
    background-color: #1abc9c;
    border-color: #16a085;
    border-radius: 4px;
}
.btn-primary:hover {
    background-color: #16a085;
    border-color: #148f77;
}
.btn-danger {
    border-radius: 4px;
}
.btn-xs {
    padding: 3px 8px;
    font-size: 11px;
}
.btn-success {
    border-radius: 4px;
}

/* ── Forms ── */
.form-control {
    border-radius: 4px;
    border: 1px solid #cdd4db;
    font-size: 13px;
    margin-bottom: 8px;
}
.form-control:focus {
    border-color: #1abc9c;
    box-shadow: 0 0 0 2px rgba(26,188,156,0.2);
}
label {
    font-weight: 600;
    font-size: 13px;
    color: #555;
    margin-top: 6px;
}

/* ── Alert messages ── */
.text-success { color: #27ae60 !important; font-weight: 600; }
.text-danger  { color: #e74c3c !important; font-weight: 600; }
.alert { border-radius: 4px; font-size: 13px; }

/* ── Manage Books admin panel links ── */
.admin-book-menu a {
    display: block;
    padding: 9px 14px;
    margin-bottom: 6px;
    background-color: #2c3e50;
    color: #ecf0f1;
    border-radius: 4px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: background 0.2s;
}
.admin-book-menu a:hover {
    background-color: #1abc9c;
    color: #fff;
}

/* ── Labels / badges ── */
.label-default {
    background-color: #95a5a6;
    font-size: 11px;
    border-radius: 3px;
    padding: 3px 7px;
}

/* ── Overflow wrapper for wide tables ── */
.table-responsive-wrapper {
    overflow-x: auto;
}

</style>
