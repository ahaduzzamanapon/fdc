@extends('layouts.ager.default')
{{-- Page title --}}
@section('title')
Crud Builder {{ __('messages.crud_builder') }} @parent
@stop
{{-- page level styles --}}
@section('header_styles')
<!-- page vendors -->
<link rel="stylesheet" href="{{ asset('vendors/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css">
<style>
    .chk-align {
        padding-right: 10px;
    }

    .chk-label-margin {
        margin-left: 5px;
    }

    .required {
        color: red;
        padding-left: 5px;
    }

    .btn-green {
        background-color: #00A65A !important;
    }

    .btn-blue {
        background-color: #2489C5 !important;
    }

    .icheckbox_square-blue {
        position: relative;
    }

</style>
<!--end of page vendors -->
@stop
{{-- Page content --}}
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>{{ __('messages.crud_generator') }}</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div id="info" style="display: none"></div>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title d-inline">{{ __('messages.crud_generator') }}</h5>
                    <span class="float-right">
                        <i class="fa fa-chevron-up clickable"></i>
                        <i class="fa fa-times removepanel clickable"></i>
                    </span>
                </div>

                <div class="card-body">
                    <form id="form">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="txtModelName">{{ __('messages.model_name') }}<span class="required">*</span></label>
                                <input type="text" class="form-control" required id="txtModelName" placeholder="{{ __('messages.enter_name') }}" pattern="[a-zA-Z0-9]+">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="drdCommandType">{{ __('messages.command_type') }}</label>
                                <select id="drdCommandType" class="form-control" style="width: 100%">
                                    <option value="infyom:api_scaffold">{{ __('messages.api_scaffold_generator') }}</option>
                                    <option value="infyom:api">{{ __('messages.api_generator') }}</option>
                                    <option value="infyom:scaffold">{{ __('messages.scaffold_generator') }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="txtCustomTblName">{{ __('messages.custom_table_name') }}</label>
                                <input type="text" class="form-control" id="txtCustomTblName"
                                    placeholder="{{ __('messages.enter_table_name') }}">
                                <small class="text-danger"></small>


                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8 col-sm-12">
                                <label for="txtModelName">{{ __('messages.options') }}</label>

                                <div class="form-inline form-group" style="border-color: transparent">
                                    <div class="checkbox chk-align">
                                        <label>
                                            <input type="checkbox" class="flat-red" id="chkDelete">
                                            <span class="chk-label-margin">{{ __('messages.soft_delete') }} </span>
                                        </label>
                                    </div>
                                    <div class="checkbox chk-align">
                                        <label>
                                            <input type="checkbox" class="flat-red" id="chkSave">
                                            <span class="chk-label-margin">{{ __('messages.save_schema') }}</span>
                                        </label>
                                    </div>
                                    <div class="checkbox chk-align" id="chTest">
                                        <label>
                                            <input type="checkbox" class="flat-red" id="chkTestCases">
                                            <span class="chk-label-margin">{{ __('messages.test_cases') }}</span>
                                        </label>
                                    </div>
                                    <div class="checkbox chk-align" id="chDataTable">
                                        <label>
                                            <input type="checkbox" class="flat-red" id="chkDataTable">
                                            <span class="chk-label-margin">{{ __('messages.datatables') }}</span>
                                        </label>
                                    </div>
                                    <div class="checkbox chk-align" id="chMigration">
                                        <label>
                                            <input type="checkbox" class="flat-red" id="chkMigration" checked>
                                            <span class="chk-label-margin">{{ __('messages.migration') }}</span>
                                        </label>
                                    </div>
                                    <div class="checkbox chk-align" id="chForceMigrate">
                                        <label>
                                            <input type="checkbox" class="flat-red" id="chkForceMigrate" checked>
                                            <span class="chk-label-margin">{{ __('messages.migrate') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="txtPaginate">{{ __('messages.paginate') }}</label>
                                <input type="number" class="form-control" value="10" id="txtPaginate" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12" style="margin-top: 7px">
                                <h5>{{ __('messages.fields') }}</h5>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    {{ __('messages.primary_key_info') }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="fieldsTable">
                                    <thead class="no-border">
                                        <tr>
                                            <th>{{ __('messages.field_name') }}</th>
                                            <th>{{ __('messages.db_type') }}</th>
                                            <th>{{ __('messages.validations') }}</th>
                                            <th>{{ __('messages.html_type') }}</th>
                                            <th>Options</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="container" class="no-border-x no-border-y ui-sortable">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-inline col-md-12" style="padding-top: 10px">
                                <div class="form-group chk-align" style="border-color: transparent;">
                                    <button type="button" class="btn btn-success btn-flat btn-green" id="btnAdd"> {{ __('messages.add_field') }}
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive col-md-12" id="relationShip"
                                style="margin-top:35px;display: none">
                                <table class="table table-striped table-bordered" id="relationTable">
                                    <thead class="no-border">
                                        <tr>
                                            <th>{{ __('messages.relation_type') }}</th>
                                            <th>{{ __('messages.foreign_model') }}<span class="required">*</span></th>
                                            <th>{{ __('messages.foreign_key') }}</th>
                                            <th>{{ __('messages.local_key') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="rsContainer" class="no-border-x no-border-y ui-sortable">

                                    </tbody>
                                </table>
                            </div>
                            <div class="form-inline col-md-12" style="padding-top: 10px">
                                <div class="form-group" style="border-color: transparent;">
                                    <button type="button" class="btn btn-success btn-flat btn-green"
                                        id="btnRelationShip">
                                        {{ __('messages.add_relationship') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-inline col-md-12" style="padding:15px 15px;text-align: right">
                                <div class="form-group" style="border-color: transparent;padding-left: 10px">
                                    <button type="submit" class="btn btn-flat btn-primary btn-blue"
                                        id="btnGenerate">{{ __('messages.generate') }}
                                    </button>
                                </div>
                                <div class="form-group" style="border-color: transparent;padding-left: 10px">
                                    <button type="button" class="btn btn-default btn-flat" id="btnReset"
                                        data-toggle="modal" data-target="#confirm-delete"> {{ __('messages.reset') }}
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">{{ __('messages.confirm_reset') }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        <p style="font-size: 16px">{{ __('messages.reset_fields_confirmation') }}</p>

                                        <p class="debug-url"></p>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">{{ __('messages.no') }}
                                        </button>
                                        <a id="btnModelReset" class="btn btn-flat btn-danger btn-ok"
                                            data-dismiss="modal">{{ __('messages.yes') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div id="rollbackInfo" style="display: none"></div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title d-inline">{{ __('messages.rollback') }}</h5>
                    <span class="float-right">
                        <i class="fa fa-chevron-up clickable"></i>
                        <i class="fa fa-times removepanel clickable"></i>
                    </span>
                </div>
                <div class="card-body">
                    <form id="rollbackForm">
                        <input type="hidden" name="_token" id="rbToken" value="{!! csrf_token() !!}" />

                        <div class="form-group col-md-4">
                            <label for="txtRBModelName">{{ __('messages.model_name') }}<span class="required">*</span></label>
                            <input type="text" class="form-control" required id="txtRBModelName"
                                placeholder="{{ __('messages.enter_name') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="drdRBCommandType">{{ __('messages.command_type') }}</label>
                            <select id="drdRBCommandType" class="form-control" style="width: 100%">
                                <option value="api_scaffold">{{ __('messages.api_scaffold_generator') }}</option>
                                <option value="api">{{ __('messages.api_generator') }}</option>
                                <option value="scaffold">{{ __('messages.scaffold_generator') }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtRBPrefix">{{ __('messages.prefix') }}</label>
                            <input type="text" class="form-control" id="txtRBPrefix" placeholder="{{ __('messages.enter_prefix') }}">
                        </div>
                        <div class="form-inline col-md-12" style="padding:15px 15px;text-align: right">
                            <div class="form-group" style="border-color: transparent;padding-left: 10px">
                                <button type="submit" class="btn btn-flat btn-primary btn-blue"
                                    id="btnRollback">{{ __('messages.rollback') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="content">
    <div class="row">
        <div class="col-12">
            <div id="schemaInfo" style="display: none"></div>
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title d-inline">{{ __('messages.generate_crud_from_schema') }}</h5>
                    <span class="float-right">
                        <i class="fa fa-chevron-up clickable"></i>
                        <i class="fa fa-times removepanel clickable"></i>
                    </span>
                </div>
                <div class="card-body">
                    <form method="post" id="schemaForm" enctype="multipart/form-data">
                        <input type="hidden" name="_token" id="smToken" value="{!! csrf_token() !!}" />
                        <div class="form-group col-md-4">
                            <label for="txtSmModelName">{{ __('messages.model_name') }}<span class="required">*</span></label>
                            <input type="text" name="modelName" class="form-control" id="txtSmModelName"
                                placeholder="{{ __('messages.enter_name') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="schemaFile">{{ __('messages.schema_file') }}<span class="required">*</span></label>
                            <input type="file" name="schemaFile" class="form-control" required id="schemaFile">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="drdSmCommandType">{{ __('messages.command_type') }}</label>
                            <select name="commandType" id="drdSmCommandType" class="form-control" style="width: 100%">
                                <option value="infyom:api_scaffold">{{ __('messages.api_scaffold_generator') }}</option>
                                <option value="infyom:api">{{ __('messages.api_generator') }}</option>
                                <option value="infyom:scaffold">{{ __('messages.scaffold_generator') }}</option>
                            </select>
                        </div>
                        <div class="form-inline col-md-12" style="padding:15px 15px;text-align: right">
                            <div class="form-group" style="border-color: transparent;padding-left: 10px">
                                <button type="submit" class="btn btn-flat btn-primary btn-blue"
                                    id="btnSmGenerate">{{ __('messages.generate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('footer_scripts')
<script src="{{ asset('vendors/select2/js/select2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

<script>
    /*
     * defining all functions here to use them later
     */
    //check if model exists
    function checkForTableExistence()
    {
        let tableName = elTable.value;

        //don't make ajax call if model value is empty
        if(tableName === "") return;

        // TODO: convert it to es6 call
        $.ajax({
            url: "{{ url('tableCheck') }}",
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({tableName}),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (result) {
                document.getElementById('btnGenerate').disabled = !result;
                if(result)
                {
                    return document.getElementById('txtCustomTblName').nextElementSibling.innerHTML = '';
                }
                                }
                return document.getElementById('txtCustomTblName').nextElementSibling.innerHTML = '{{ __('messages.table_name_exists') }}';
            }
        });
    }


    // enable/disable "Generate" button dynamically based on validation
    function setButtonStatus(status)
    {
        document.getElementById('btnGenerate').disabled = !status;
    }

    function setTableName(){
        // if table name set using its own input, then don't change it anymore
        if(customTableName) return;
        //set table name
        const tableField = document.getElementById('txtCustomTblName');
        if (elModel.value === "") {
            tableField.value = '';
        }
        else {
            tableField.value = elModel.value.concat('s').toLowerCase();
        }

        // finally check whether a table with same name exists or not
        checkForTableExistence();
    }

    function capitalizeModelName(e){
        elModel.value = elModel.value.charAt(0).toUpperCase() + elModel.value.slice(1);

        //finally set table name
        setTableName();
    }

    //check for duplicate field names
    function hasDuplicates(arr)
    {
        return new Set(arr).size !== arr.length;
    }

    function checkForDuplicateFieldNames(e)
    {
        const nodeList = document.querySelectorAll('.txtFieldName');
        const reservedFields = ['id','created_at','updated_at','deleted_at'];
        if(reservedFields.includes(e.target.value))
        {
            e.target.classList.add('is-invalid');
            setButtonStatus(false);
            return e.target.nextElementSibling.nextElementSibling.innerHTML = `<strong>${e.target.value}</strong> {{ __('messages.field_created_automatically') }}`;
        }
        let fields = [];
        nodeList.forEach(node => fields.push( node.value));

        if (hasDuplicates(fields)) {
            e.target.classList.add('is-invalid');
            setButtonStatus(false);
            e.target.nextElementSibling.nextElementSibling.innerHTML = "{{ __('messages.duplicate_field_name') }}";

        }
        else {
            e.target.classList.remove('is-invalid');
            setButtonStatus(true);
        }

    }

    /*
     * usual functionality starts here
     */

    $("select").select2({width: '100%'});
    var fieldIdArr = [];
    $(function () {
        /* $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        }); */

        $("#drdCommandType").on("change", function () {
            if ($(this).val() === "infyom:scaffold") {
                $('#chSwag').hide();
                $('#chTest').hide();
            }
            else {
                $('#chSwag').show();
                $('#chTest').show();
            }
        });

        $("#chkForceMigrate").on("ifChanged", function () {
            if ($(this).prop('checked') === true) {
                $('#chkMigration').iCheck("check", true);
                $('#chkMigration').iCheck("disable", true);
            } else {
                $('#chkMigration').iCheck("enable", true);
            }
        });

        $(document).ready(function () {
            var htmlStr = '<tr class="item" style="display: table-row;"></tr>';
            var commonComponent = $(htmlStr).filter("tr").load('{{ route('io_field_template') }}');
            var relationStr = '<tr class="relationItem" style="display: table-row;"></tr>';
            var relationComponent = $(relationStr).filter("tr").load('{{ route('io_relation_field_template') }}');

            $("#btnAdd").on("click", function () {
                var item = $(commonComponent).clone();
                initializeCheckbox(item);
                $("#container").append(item);
            });

            $("#btnRelationShip").on("click", function () {
                $("#relationShip").show();
                var item = $(relationComponent).clone();

                $(item).find("select").select2({ width: '100%' });

                var relationType = $(item).find('.drdRelationType');

                $(relationType).select2().on('change', function () {
                    if ($(relationType).val() === "mtm")
                        $(item).find('.foreignTable').show();
                    else
                        $(item).find('.foreignTable').hide();
                });

                $("#rsContainer").append(item);
            });

            $("#btnModelReset").on("click", function () {
                $("#container").html("");
                $('input:text').val("");
                $('input:checkbox').iCheck('uncheck');

            });

            $("#form").on("submit", function () {
                setButtonStatus(false);
                let fieldArr = [];
                let relationFieldArr = [];
                $('.item').each(function () {

                    var htmlType = $(this).find('.drdHtmlType');
                    let htmlValue;
                    if ($(htmlType).val() === "select" || $(htmlType).val() === "radio") {
                        htmlValue = $(this).find('.drdHtmlType').val() + ',' + $(this).find('.txtHtmlValue').val();
                    }
                    else {
                        htmlValue = $(this).find('.drdHtmlType').val();
                    }

                    fieldArr.push({
                        name: $(this).find('.txtFieldName').val(),
                        dbType: $(this).find('.txtdbType').val(),
                        htmlType: htmlValue,
                        validations: $(this).find('.txtValidation').val(),
                        foreignTable: $(this).find('.txtForeignTable').val(),
                        isForeign: $(this).find('.chkForeign').prop('checked'),
                        searchable: $(this).find('.chkSearchable').prop('checked'),
                        fillable: $(this).find('.chkFillable').prop('checked'),
                        primary: $(this).find('.chkPrimary').prop('checked'),
                        inForm: $(this).find('.chkInForm').prop('checked'),
                        inIndex: $(this).find('.chkInIndex').prop('checked')
                    });
                });

                $('.relationItem').each(function () {
                    relationFieldArr.push({
                        relationType: $(this).find('.drdRelationType').val(),
                        foreignModel: $(this).find('.txtForeignModel').val(),
                        foreignTable: $(this).find('.txtForeignTable').val(),
                        foreignKey: $(this).find('.txtForeignKey').val(),
                        localKey: $(this).find('.txtLocalKey').val(),
                    });
                });

                // add id to fieldsArr
                fieldArr.unshift({
                name: 'id',
                dbType: 'increments',
                htmlType: "number",
                validations: "",
                foreignTable: "",
                isForeign: false,
                searchable: true,
                fillable: false,
                primary: true,
                inForm: false,
                inIndex: true
                });

                // add timestaps to fieldArr
                fieldArr.push({
                name: 'created_at',
                dbType: 'timestamp',
                htmlType: "date",
                validations: "",
                foreignTable: "",
                isForeign: false,
                searchable: false,
                fillable: false,
                primary: false,
                inForm: false,
                inIndex: true
                });
                fieldArr.push({
                name: 'updated_at',
                dbType: 'timestamp',
                htmlType: "date",
                validations: "",
                foreignTable: "",
                isForeign: false,
                searchable: false,
                fillable: false,
                primary: false,
                inForm: false,
                inIndex: true
                });

                var data = {
                    modelName: $('#txtModelName').val(),
                    commandType: $('#drdCommandType').val(),
                    tableName: $('#txtCustomTblName').val(),
                    migrate: $('#chkMigration').prop('checked'),
                    options: {
                        softDelete: $('#chkDelete').prop('checked'),
                        save: $('#chkSave').prop('checked'),
                        prefix: $('#txtPrefix').val(),
                        paginate: $('#txtPaginate').val(),
                        forceMigrate: $('#chkForceMigrate').prop('checked'),
                    },
                    addOns: {
                        tests: $('#chkTestCases').prop('checked'),
                        datatables: $('#chkDataTable').prop('checked')
                    },
                    fields: fieldArr,
                    relations: relationFieldArr
                };

                data['_token'] = $("input[name=_token]").val();

                $.ajax({
                    url: '{{ route('io_generator_builder_generate') }}',
                   // type: "POST",
                    method: "POST",
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function (result) {
                        $("#info").html("");
                        $("#info").append('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' + result + '</strong></div>');
                        $("#info").show();
                        var $container = $("html,body");
                        var $scrollTo = $('#info');
                        $container.animate({scrollTop: $scrollTo.offset().top - $container.offset().top, scrollLeft: 0},300);
                        setTimeout(function () {
                            $('#info').fadeOut('fast');
                        }, 3000);
                        location.reload();
                    },
                    error: function (result) {
                        var result = JSON.parse(JSON.stringify(result));
                        var errorMessage = '';
                        if (result.hasOwnProperty('responseJSON') && result.responseJSON.hasOwnProperty('message')) {
                            errorMessage = result.responseJSON.message;
                        }

                        $("#info").html("");
                        $("#info").append('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>{{ __('messages.fail') }} </strong>' + errorMessage + '</div>');
                        $("#info").show();
                        var $container = $("html,body");
                        var $scrollTo = $('#info');
                        $container.animate({ scrollTop: $scrollTo.offset().top}, 300);
                        setTimeout(function () {
                            $('#info').fadeOut('fast');
                        }, 3000);
                    }
                });

                return false;
            });

            $('#rollbackForm').on("submit", function (e) {
                e.preventDefault();

                var data = {
                    modelName: $('#txtRBModelName').val(),
                    commandType: $('#drdRBCommandType').val(),
                    prefix: $('#txtRBPrefix').val(),
                    _token: $('#rbToken').val()
                };

                $.ajax({
                    url: '{{ route('io_generator_builder_rollback') }}',
                    method: "POST",
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function (result) {
                        var result = JSON.parse(JSON.stringify(result));

                        $("#rollbackInfo").html("");
                        $("#rollbackInfo").append('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' + result.message + '</strong></div>');
                        $("#rollbackInfo").show();

                        var $container = $("html,body");
                        var $scrollTo = $('#rollbackInfo');
                        $container.animate({
                            scrollTop: $scrollTo.offset().top - $container.offset().top,
                            scrollLeft: 0
                        }, 300);
                        setTimeout(function () {
                            $('#rollbackInfo').fadeOut('fast');
                        }, 3000);
                        location.reload();
                    },
                    error: function (result) {
                        var result = JSON.parse(JSON.stringify(result));
                        var errorMessage = '';
                        if (result.hasOwnProperty('responseJSON') && result.responseJSON.hasOwnProperty('message')) {
                            errorMessage = result.responseJSON.message;
                        }

                        $("#rollbackInfo").html("");
                        $("#rollbackInfo").append('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Fail! </strong>' + errorMessage + '</div>');
                        $("#rollbackInfo").show();
                        setTimeout(function () {
                            $('#rollbackInfo').fadeOut('fast');
                        }, 3000);
                    }
                });
            });

            $('#schemaFile').change(function () {
                var ext = $(this).val().split('.').pop().toLowerCase();
                if (ext !== 'json') {
                    $("#schemaInfo").html("");
                    $("#schemaInfo").append('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>{{ __('messages.schema_file_must_be_json') }}</strong></div>');
                    $("#schemaInfo").show();
                    $(this).replaceWith($(this).val('').clone(true));
                    setTimeout(function () {
                        $('div.alert').fadeOut('fast');
                    }, 3000);
                }
            });

            $('#schemaForm').on("submit", function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('io_generator_builder_generate_from_file') }}',
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        var result = JSON.parse(JSON.stringify(result));

                        $("#schemaInfo").html("");
                        $("#schemaInfo").append('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' + result.message + '</strong></div>');
                        $("#schemaInfo").show();
                        var $container = $("html,body");
                        var $scrollTo = $('#schemaInfo');
                        $container.animate({
                            scrollTop: $scrollTo.offset().top - $container.offset().top,
                            scrollLeft: 0
                        }, 300);
                        setTimeout(function () {
                            $('#schemaInfo').fadeOut('fast');
                        }, 3000);
                        location.reload();
                    },
                    error: function (result) {
                        var result = JSON.parse(JSON.stringify(result));
                        var errorMessage = '';
                        if (result.hasOwnProperty('responseJSON') && result.responseJSON.hasOwnProperty('message')) {
                            errorMessage = result.responseJSON.message;
                        }

                        $("#schemaInfo").html("");
                        $("#schemaInfo").append('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Fail! </strong>' + errorMessage + '</div>');
                        $("#schemaInfo").show();
                        setTimeout(function () {
                            $('#schemaInfo').fadeOut('fast');
                        }, 3000);
                    }
                });
            });

            function renderPrimaryData(el) {

                $('.chkPrimary').iCheck(getiCheckSelection(false));

                $(el).find('.txtFieldName').val("id");
                $(el).find('.txtdbType').val("increments");
                $(el).find('.chkSearchable').attr('checked', false);
                $(el).find('.chkFillable').attr('checked', false);
                $(el).find('.chkPrimary').attr('checked', true);
                $(el).find('.chkInForm').attr('checked', false);
                $(el).find('.chkInIndex').attr('checked', false);
                $(el).find('.drdHtmlType').val('number').trigger('change');
            }

            function renderTimeStampData(el) {
                $(el).find('.txtdbType').val("timestamp");
                $(el).find('.chkSearchable').attr('checked', false);
                $(el).find('.chkFillable').attr('checked', false);
                $(el).find('.chkPrimary').attr('checked', false);
                $(el).find('.chkInForm').attr('checked', false);
                $(el).find('.chkInIndex').attr('checked', false);
                $(el).find('.drdHtmlType').val('date').trigger('change');
            }

        });

        function initializeCheckbox(el) {
            $(el).find('input:checkbox').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue'
            });
            $(el).find("select").select2({width: '100%'});

            $(el).find(".chkPrimary").on("ifClicked", function () {
                $('.chkPrimary').each(function () {
                    $(this).iCheck('uncheck');
                });
            });

            $(el).find(".chkForeign").on("ifChanged", function () {
                if ($(this).prop('checked') === true) {
                    $(el).find('.foreignTable').show();
                } else {
                    $(el).find('.foreignTable').hide();
                }
            });

            $(el).find(".chkPrimary").on("ifChanged", function () {
                if ($(this).prop('checked') === true) {
                    $(el).find(".chkSearchable").iCheck('uncheck');
                    $(el).find(".chkFillable").iCheck('uncheck');
                    $(el).find(".chkInForm").iCheck('uncheck');
                }
            });

            var htmlType = $(el).find('.drdHtmlType');

            $(htmlType).select2().on('change', function () {
                if ($(htmlType).val() === "select" || $(htmlType).val() === "radio")
                    $(el).find('.htmlValue').show();
                else
                    $(el).find('.htmlValue').hide();
            });

        }

    });

    function getiCheckSelection(value) {
        if (value === true)
            return 'checked';
        else
            return 'uncheck';
    }

    function removeItem(e) {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }

    let elModel = document.getElementById('txtModelName');
    let elTable = document.getElementById('txtCustomTblName');
    let customTableName = false;

    // sanitize model input
    elModel.addEventListener('keypress', (e) => {
        const key = e.keyCode;
        if(!((key >= 65 && key <= 90) || (key >= 97 && key <= 122))) e.preventDefault();
    });

    // capitalize elModel
    elModel.addEventListener('keyup',capitalizeModelName);

    // check for table existence when custom table name is set
    document.getElementById('txtCustomTblName').addEventListener('keyup', () => {
        customTableName = true;
        checkForTableExistence();
    });


    /***
     * Fields related logic
     */

    // do not allow other characters for field names
    const fields = document.querySelector('#fieldsTable');
    fields.addEventListener('keypress', (e) => {
        if(e.target.classList.contains('txtFieldName')) {
            const rule = new RegExp("^[a-zA-Z_][a-zA-Z0-9_]*$");
            console.log(e.target.value+e.key);
            if(!rule.test(e.target.value+e.key)) e.preventDefault();
        }
    });

    fields.addEventListener('keyup',checkForDuplicateFieldNames);

</script>

@stop
