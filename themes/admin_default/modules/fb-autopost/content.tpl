<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->

<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="panel panel-default">
        <div class="panel-body">
            <input type="hidden" name="id" value="{ROW.id}" />
            <div class="form-group">
                <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.link}</strong> <span class="red">(*)</span></label>
                <div class="col-sm-19 col-md-21">
                    <input class="form-control" type="url" value="{ROW.link}" name="link" required="required" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.subject}</strong></label>
                <div class="col-sm-19 col-md-21">
                    <input class="form-control" type="text" name="subject" value="{ROW.subject}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.description}</strong></label>
                <div class="col-sm-19 col-md-21">
                    <textarea class="form-control" name="description">{ROW.description}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.message}</strong></label>
                <div class="col-sm-19 col-md-21">
                    <textarea class="form-control" style="height: 200px;" name="message">{ROW.message}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.image}</strong></label>
                <div class="col-sm-19 col-md-21">
                    <div class="input-group">
                        <input class="form-control" type="text" name="image" value="{ROW.image}" id="id_image" /> <span class="input-group-btn">
                            <button class="btn btn-default selectfile" type="button">
                                <em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- BEGIN: queuetime -->
            <div class="form-group">
                <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.queuetime}</strong></label>
                <div class="col-sm-19 col-md-21">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-24 col-sm-12 col-md-12">
                                    <select class="form-control" name="hour">
                                        <option value="0">---{LANG.hour_c}---</option>
                                        <!-- BEGIN: hour -->
                                        <option value="{HOUR.index}"{HOUR.selected}>{HOUR.index}</option>
                                        <!-- END: hour -->
                                    </select>
                                </div>
                                <div class="col-xs-24 col-sm-12 col-md-12">
                                    <select class="form-control" name="minute">
                                        <option value="0">---{LANG.minute_c}---</option>
                                        <!-- BEGIN: minute -->
                                        <option value="{MINUTE.index}"{MINUTE.selected}>{MINUTE.index}</option>
                                        <!-- END: minute -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="input-group">
                                <input class="form-control datepicker" value="{ROW.queuetime}" type="text" name="queuetime" placeholder="{LANG.filter_to}" /> <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <em class="fa fa-calendar fa-fix">&nbsp;</em>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: queuetime -->
        </div>
    </div>
    <div class="form-group text-center">
        <input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
    </div>
</form>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
    //<![CDATA[
    $(".datepicker").datepicker({
        dateFormat : "dd/mm/yy",
        changeMonth : !0,
        changeYear : !0,
        showOtherMonths : !0,
        showOn : "focus",
        yearRange : "-90:+0"
    });
    
    $(".selectfile").click(function() {
        var area = "id_image";
        var path = "{NV_UPLOADS_DIR}";
        var currentpath = "{CURRENT_PATH}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    //]]>
</script>
<!-- END: main -->