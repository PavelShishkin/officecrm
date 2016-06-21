
var EditableTable = function () {
 
    return {

        //main function to initiate the module
        init: function () {
            
            function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }

                oTable.fnDraw();
            }

            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
            
                jqTds[0].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[0] + '">';
                jqTds[1].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<a class="edit" href="">Save</a>';
               
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
            
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                oTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, 4, false);
                oTable.fnDraw();
               
                if(jqInputs[0].value == 'status')
                {
                   openUrl('index.php', {status_id:jqInputs[1].value,status_name:jqInputs[2].value,action:"status_update"}) 
                }
                else if(jqInputs[0].value == 'stage')
                {
                    openUrl('index.php', {stage_id:jqInputs[1].value,stage_name:jqInputs[2].value,action:"stage_update"})
                }
            }
            
           

            function cancelEditRow(statusTable, nRow) {
                var jqInputs = $('input', nRow);
                
                statusTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                statusTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                statusTable.fnUpdate(jqInputs[2].value, nRow, 2, false);

                statusTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                statusTable.fnDraw();
            }
            
            // ----------------------------СТАТУС ДЕЛА
            
            function statusRestoreRow(statusTable, nRow) {
                var aData = statusTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    statusTable.fnUpdate(aData[i], nRow, i, false);
                }

                statusTable.fnDraw();
            }

            function statusEditRow( statusTable, nRow) {
                var aData =  statusTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
            
                jqTds[0].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[0] + '">';
                jqTds[1].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<a class="edit" href="">Save</a>';
               
            }

            function statusSaveRow( statusTable, nRow) {
                var jqInputs = $('input', nRow);
            
                 statusTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                 statusTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                 statusTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                 statusTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                 statusTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, 4, false);
                 statusTable.fnDraw();
               
                if(jqInputs[0].value == 'status')
                {
                   openUrl('index.php', {status_id:jqInputs[1].value,status_name:jqInputs[2].value,action:"status_update"}) 
                }
                else if(jqInputs[0].value == 'stage')
                {
                    openUrl('index.php', {stage_id:jqInputs[1].value,stage_name:jqInputs[2].value,action:"stage_update"})
                }
            }
            
           

            function statusCancelEditRow( statusTable, nRow) {
                var jqInputs = $('input', nRow);
                
                 statusTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                 statusTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                 statusTable.fnUpdate(jqInputs[2].value, nRow, 2, false);

                 statusTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                 statusTable.fnDraw();
            }
            
            // ----------------------------СТАТУС ДЕЛА
            
            // ----------------------------КАТЕГОРИИ
            
            function categorRestoreRow(categorTable, nRow) {
                var aData = categorTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    categorTable.fnUpdate(aData[i], nRow, i, false);
                }

                categorTable.fnDraw();
            }

            function categorEditRow( categorTable, nRow) {
                var aData =  categorTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
            
                jqTds[0].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[0] + '">';
                jqTds[1].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<a class="edit" href="">Save</a>';
               
            }

            function categorSaveRow( categorTable, nRow) {
                var jqInputs = $('input', nRow);
            
                 categorTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                 categorTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                 categorTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                 categorTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                 categorTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, 4, false);
                 categorTable.fnDraw();
               
                 openUrl('index.php', {categor_id:jqInputs[1].value,categor_name:jqInputs[2].value,action:"categor_update"}) 
               
            }
            
           

            function categorCancelEditRow( categorTable, nRow) {
                var jqInputs = $('input', nRow);
                
                 categorTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                 categorTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                 categorTable.fnUpdate(jqInputs[2].value, nRow, 2, false);

                 categorTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                 categorTable.fnDraw();
            }
            
            // ----------------------------КАТЕГОРИИ
            
            // ----------------------------ДОЛЖНОСТИ
            
            function postRestoreRow(postTable, nRow) {
                var aData = postTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    postTable.fnUpdate(aData[i], nRow, i, false);
                }

                postTable.fnDraw();
            }

            function postEditRow( postTable, nRow) {
                var aData =  postTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
            
                jqTds[0].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[0] + '">';
                jqTds[1].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<a class="edit" href="">Save</a>';
               
            }

            function postSaveRow( postTable, nRow) {
                var jqInputs = $('input', nRow);
            
                 postTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                 postTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                 postTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                 postTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                 postTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, 4, false);
                 postTable.fnDraw();
               
                 openUrl('index.php', {post_id:jqInputs[1].value,post_name:jqInputs[2].value,action:"post_update"}) 
               
            }
            
           

            function postCancelEditRow( postTable, nRow) {
                var jqInputs = $('input', nRow);
                
                 postTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                 postTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                 postTable.fnUpdate(jqInputs[2].value, nRow, 2, false);

                 postTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                 postTable.fnDraw();
            }
            
            // ----------------------------ДОЛЖНОСТИ
            
            // ----------------------------СТАТУС ДЕЛА
            
            function contr_typeRestoreRow(contr_typeTable, nRow) {
                var aData = contr_typeTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    contr_typeTable.fnUpdate(aData[i], nRow, i, false);
                }

                contr_typeTable.fnDraw();
            }

            function contr_typeEditRow( contr_typeTable, nRow) {
                var aData =  contr_typeTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
            
                jqTds[0].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[0] + '">';
                jqTds[1].innerHTML =  '<input type="hidden" class="form-control small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<a class="edit" href="">Save</a>';
               
            }

            function contr_typeSaveRow( contr_typeTable, nRow) {
                var jqInputs = $('input', nRow);
            
                 contr_typeTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                 contr_typeTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                 contr_typeTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                 contr_typeTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                 contr_typeTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, 4, false);
                 contr_typeTable.fnDraw();
               
                if(jqInputs[0].value == 'contr_type')
                {
                   openUrl('index.php', {contr_type_id:jqInputs[1].value,contr_type_name:jqInputs[2].value,action:"contr_type_update"}) 
                }
               
            }
            
           

            function contr_typeCancelEditRow( contr_typeTable, nRow) {
                var jqInputs = $('input', nRow);
                
                 contr_typeTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                 contr_typeTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                 contr_typeTable.fnUpdate(jqInputs[2].value, nRow, 2, false);

                 contr_typeTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 3, false);
                 contr_typeTable.fnDraw();
            }
            
            // ----------------------------СТАТУС ДЕЛА
            

            var oTable = $('#editable-sample').dataTable({
               
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength":  -1,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            
            jQuery('#editable-sample_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page dropdown
            
            //-------------- СТАТУС ДЕЛА ---------------------------------------------------------------------------
            var statusTable = $('#editable-sample_2').dataTable({
               
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength":  -1,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            
            jQuery('#editable-sample_2_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_2_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page
            //-------------- СТАТУС ДЕЛА ---------------------------------------------------------------------------
            
             //-------------- КАТЕГОРИИ ---------------------------------------------------------------------------
            var categorTable = $('#editable-sample_3').dataTable({
               
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength":  -1,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            
            jQuery('#editable-sample_3_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_3_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page
            //-------------- КАТЕГОРИИ ---------------------------------------------------------------------------
           
            //-------------- ДОЛЖНОСТИ ---------------------------------------------------------------------------
            var postTable = $('#editable-sample_4').dataTable({
               
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength":  -1,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            
            jQuery('#editable-sample_4_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_4_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page
            //-------------- Должности ---------------------------------------------------------------------------
            
           //-------------- ТИП КОНТРАГЕНТА ---------------------------------------------------------------------------
            var contr_typeTable = $('#editable-sample_5').dataTable({
               
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength":  -1,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            
            jQuery('#editable-sample_5_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_5_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page
            //-------------- ТИП КОНТРАГЕНТА ---------------------------------------------------------------------------

            var nEditing = null;
            
            function openUrl(url, post)
            {
                if ( post ) {
                    var form = $('<form/>', {
                        action: url,
                        method: 'POST',
                        style: {
                           display: 'none'
                        }
                    });

                    for(var key in post) {
                        form.append($('<input/>',{
                            type: 'hidden',
                            name: key,
                            value: post[key]
                        }));
                    }

                    form.appendTo(document.body); // Необходимо для некоторых браузеров
                    form.submit();

                } 
            }
           
            
            
            $('#editable-sample_new').click(function (e) {
                
                
                
                openUrl('index.php', {action:"status_add"}); 
                
            });

            $('#editable-sample a.delete').live('click', function (e) {
      
                e.preventDefault();
                
                var nRow = $(this).parents('tr')[0];
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML =   aData[0];
                jqTds[1].innerHTML =   aData[1];
                
                if(jqTds[0].innerHTML == 'status')
                {
                   openUrl('index.php', {status_id:jqTds[1].innerHTML,action:"status_delete"}) 
                }
                oTable.fnDeleteRow(nRow);
            });

            $('#editable-sample a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample a.edit').live('click', function (e) {
                e.preventDefault();
                
                
                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];
                if (nEditing !== null && nEditing != nRow) 
                {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } 
                else if (nEditing == nRow && this.innerHTML == "Save") 
                {
                    
                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;
                   
                } 
                else 
                {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });
            
            
            
            
            
            
            
            
            //-------------- СТАТУС ДЕЛА ---------------------------------------------------------------------------
            
            $('#editable-sample_new_2').click(function (e) {
                /*
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '','', 
                        '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                
                var nRow = oTable.fnGetNodes(aiNew[0]);
               
                editRow(oTable, nRow);
                nEditing = nRow;*/
                openUrl('index.php', {action:"stage_add"}); 
                
            });

            $('#editable-sample_2 a.delete').live('click', function (e) {
      
                e.preventDefault();
                
                var nRow = $(this).parents('tr')[0];
                var aData = statusTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML =   aData[0];
                jqTds[1].innerHTML =   aData[1];
                
                openUrl('index.php', {stage_id:jqTds[1].innerHTML,action:"stage_delete"}) 
                
                statusTable.fnDeleteRow(nRow);
            });

            $('#editable-sample_2 a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    statusTable.fnDeleteRow(nRow);
                } else {
                    statusRestoreRow(statusTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample_2 a.edit').live('click', function (e) {
                e.preventDefault();
               
                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];
                if (nEditing !== null && nEditing != nRow) 
                {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    ststuRestoreRow(statusTable, nEditing);
                    statusEditRow(statusTable, nRow);
                    nEditing = nRow;
                } 
                else if (nEditing == nRow && this.innerHTML == "Save") 
                {
                    
                    /* Editing this row and want to save it */
                    statusSaveRow(statusTable, nEditing);
                    nEditing = null;
                   
                } 
                else 
                {
                    /* No edit in progress - let's start one */
                    statusEditRow(statusTable, nRow);
                    nEditing = nRow;
                }
            });
            
            //-------------- СТАТУС ДЕЛА ---------------------------------------------------------------------------
            
            //-------------- КАТЕГОРИИ ---------------------------------------------------------------------------
            
            $('#editable-sample_new_3').click(function (e) {
                /*
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '','', 
                        '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                
                var nRow = oTable.fnGetNodes(aiNew[0]);
               
                editRow(oTable, nRow);
                nEditing = nRow;*/
                openUrl('index.php', {action:"categor_add"}); 
                
            });

            $('#editable-sample_3 a.delete').live('click', function (e) {
                e.preventDefault();
                
                var nRow = $(this).parents('tr')[0];
                var aData = categorTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML =   aData[0];
                jqTds[1].innerHTML =   aData[1];
                
                openUrl('index.php', {categor_id:jqTds[1].innerHTML,action:"categor_delete"}) 
                
                categorTable.fnDeleteRow(nRow);
            });

            $('#editable-sample_3 a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    categorTable.fnDeleteRow(nRow);
                } else {
                    categorRestoreRow(categorTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample_3 a.edit').live('click', function (e) {
                e.preventDefault();
                
                
                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];
                if (nEditing !== null && nEditing != nRow) 
                {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    categorRestoreRow(categorTable, nEditing);
                    categorEditRow(categorTable, nRow);
                    nEditing = nRow;
                } 
                else if (nEditing == nRow && this.innerHTML == "Save") 
                {
                    
                    /* Editing this row and want to save it */
                    categorSaveRow(categorTable, nEditing);
                    nEditing = null;
                   
                } 
                else 
                {
                    /* No edit in progress - let's start one */
                    categorEditRow(categorTable, nRow);
                    nEditing = nRow;
                }
            });
            
            //-------------- КАТЕГОРИИ ---------------------------------------------------------------------------
            
            //-------------- Должности ---------------------------------------------------------------------------
            
            $('#editable-sample_new_4').click(function (e) {
                /*
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '','', 
                        '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                
                var nRow = oTable.fnGetNodes(aiNew[0]);
               
                editRow(oTable, nRow);
                nEditing = nRow;*/
                openUrl('index.php', {action:"post_add"}); 
                
            });

            $('#editable-sample_4 a.delete').live('click', function (e) {
                e.preventDefault();
                
                var nRow = $(this).parents('tr')[0];
                var aData = postTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML =   aData[0];
                jqTds[1].innerHTML =   aData[1];
                
                openUrl('index.php', {post_id:jqTds[1].innerHTML,action:"post_delete"}) 
                
                postTable.fnDeleteRow(nRow);
            });

            $('#editable-sample_4 a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    postTable.fnDeleteRow(nRow);
                } else {
                    postRestoreRow(postTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample_4 a.edit').live('click', function (e) {
                e.preventDefault();
                
                
                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];
                if (nEditing !== null && nEditing != nRow) 
                {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    postRestoreRow(postTable, nEditing);
                    postEditRow(postTable, nRow);
                    nEditing = nRow;
                } 
                else if (nEditing == nRow && this.innerHTML == "Save") 
                {
                    
                    /* Editing this row and want to save it */
                    postSaveRow(postTable, nEditing);
                    nEditing = null;
                   
                } 
                else 
                {
                    /* No edit in progress - let's start one */
                    postEditRow(postTable, nRow);
                    nEditing = nRow;
                }
            });
            
            //-------------- Должности ---------------------------------------------------------------------------
            
            
            //-------------- ТИП КОНТРАГЕНТА ---------------------------------------------------------------------------
            
            $('#editable-sample_new_5').click(function (e) {
                /*
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '','', 
                        '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                
                var nRow = oTable.fnGetNodes(aiNew[0]);
               
                editRow(oTable, nRow);
                nEditing = nRow;*/
                openUrl('index.php', {action:"contr_type_add"}); 
                
            });

            $('#editable-sample_5 a.delete').live('click', function (e) {
      
                e.preventDefault();
                
                var nRow = $(this).parents('tr')[0];
                var aData = contr_typeTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML =   aData[0];
                jqTds[1].innerHTML =   aData[1];
                
                openUrl('index.php', {contr_type_id:jqTds[1].innerHTML,action:"contr_type_delete"}) 
                
                contr_typeTable.fnDeleteRow(nRow);
            });

            $('#editable-sample_5 a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    contr_typeTable.fnDeleteRow(nRow);
                } else {
                    contr_typeRestoreRow(contr_typeTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample_5 a.edit').live('click', function (e) {
                e.preventDefault();
               
                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];
                if (nEditing !== null && nEditing != nRow) 
                {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    contr_typeRestoreRow(contr_typeTable, nEditing);
                    contr_typeEditRow(contr_typeTable, nRow);
                    nEditing = nRow;
                } 
                else if (nEditing == nRow && this.innerHTML == "Save") 
                {
                    
                    /* Editing this row and want to save it */
                    contr_typeSaveRow(contr_typeTable, nEditing);
                    nEditing = null;
                   
                } 
                else 
                {
                    /* No edit in progress - let's start one */
                    contr_typeEditRow(contr_typeTable, nRow);
                    nEditing = nRow;
                }
            });
            
            //-------------- СТАТУС ДЕЛА ---------------------------------------------------------------------------
        }

    };

}();
    
