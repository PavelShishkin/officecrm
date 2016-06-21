


var Script = function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
   // заседание дело встреча и т.п
    $('#external-events div.external-event').each(function() {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
        };
        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });


    /* initialize the calendar
     -----------------------------------------------------------------*/

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        
        drop: function(date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');
            
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            
            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
          
            
            
            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
            
            //добавление в БД 
            alert(copiedEventObject['title']);
            alert(copiedEventObject['start']);
            
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {

                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }

        },
        events: [
                <?php 
               
                //end: new Date(y, m, 29),
                include  ($_SERVER['DOCUMENT_ROOT']. "/officecrm/autoload.php");

                $database = new database;
          
                if($status === '')//все задачи
                {   
                    $array_task = $database->db_get_task();
                    $array_office_contragent = $database->db_get_contragent();
                    $array_office_contact = $database->db_get_contact();
                    
                    
                     foreach($array_task as $task)
                     {   
                        if($task['task_contact_id'] !== '0')
                        {
                            if($_SESSION['user_type'] === '1')
                            {
                                $url = '?location=contact_one&id='.$task['task_contact_id'].'&flag=up';
                            }
                            else
                            {
                                if(sizeof($array_office_contragent))
                                {
                                    foreach($array_office_contact as $contact)
                                    {
                                        if( $task['task_contact_id'] === $contact['cont_id'])
                                        {
                                            $url = '?location=contact_one&id='.$task['task_contact_id'].'&flag=up';
                                            break;
                                        }
                                        else
                                        {
                                            $url = false;
                                            break;
                                        }
                                    }
                                }
                                else
                                {
                                    $url = false;
                                    break;
                                }
                               
                             
                            }
                            
                            if($url !== false)
                            {
                                print"{
                                    title: '".$task['task_name'].' '.$task['task_time']."',
                                    start: '".date_format(date_create($task['task_date']),'Y-m-d')."',
                                    url: '".$url."'
                                   },";   
                            }
                        }
                     }
                    
                     foreach($array_task as $task)
                     {
                        if($task['task_contragent_id'] !== '0')
                        {
                            if($_SESSION['user_type'] === '1')
                            {
                                $url = '?location=kontragent_one&id='.$task['task_contragent_id'].'&flag=up';
                            }
                            else
                            {
                                if(sizeof($array_office_contragent))
                                {
                                    foreach($array_office_contragent as $contragent)
                                    {
                                        if($task['task_contragent_id'] === $contragent['contr_id'])
                                        {
                                            $url = '?location=kontragent_one&id='.$task['task_contragent_id'].'&flag=up';
                                            break;
                                        }
                                        else
                                        {
                                            $url = false;
                                            break;
                                        }
                                    }
                                }
                                else
                                {
                                   $url = false;
                                   break; 
                                }
                            }
                            
                        }
                        else
                        {
                            $url = false;
                        }
                        
                       
                        if($url !== false)
                        {
                            print"{
                                title: '".$task['task_name'].' '.$task['task_time']."',
                                start: '".date_format(date_create($task['task_date']),'Y-m-d')."',
                                url: '".$url."'
                               },";   
                        }
                     }
                    
                }
                elseif($status === 'all_contact')// задачи всех контактов
                {
                    $array_contact = $database->db_get_task_contact();
                    $array_office_contact = $database->db_get_contact();
                    
                    foreach($array_contact as $task)
                    {
                        if($_SESSION['user_type'] === '1')
                        {
                            $url = '?location=contact_one&id='.$task['task_contact_id'].'&flag=up';
                        }
                        else
                        {
                            if(sizeof($array_office_contact))
                            {
                                foreach($array_office_contact as $contact)
                                {
                                    if( $task['task_contact_id'] === $contact['cont_id'])
                                    {
                                        $url = '?location=contact_one&id='.$task['task_contact_id'].'&flag=up';
                                        break;
                                    }
                                    else
                                    {
                                       $url = false;
                                       break;
                                    }
                                }
                            }
                            else
                            {
                               $url = false;
                               break; 
                            }
                             
                        }
                        
                        if($url !== false)
                        {
                            print"{
                                title: '".$task['task_name'].' '.$task['task_time']."',
                                start: '".date_format(date_create($task['task_date']),'Y-m-d')."',
                                url: '".$url."'
                               },";   
                        }
                    }
                }
                elseif($status === 'all_contragent')// задачи всех контрагентов
                {
                    $array_contragent = $database->db_get_task_contragent();
                    $array_office_contragent = $database->db_get_contragent();
                    
                    foreach($array_contragent as $task)
                    {
                        if($_SESSION['user_type'] === '1')
                        {
                            $url = '?location=kontragent_one&id='.$task['task_contragent_id'].'&flag=up';
                        }
                        else
                        {
                            if(sizeof($array_office_contragent))
                            {
                                foreach($array_office_contragent as $contragent)
                                {
                                    if($task['task_contragent_id'] === $contragent['contr_id'])
                                    {
                                        $url = '?location=kontragent_one&id='.$task['task_contragent_id'].'&flag=up';
                                        break;
                                    }
                                    else
                                    {
                                        $url = false;
                                        break;
                                    }
                                }
                            }
                            else
                            {
                                $url = false;
                                break;
                            }
                        }
                        
                        if($url !== false)
                        {
                            print"{
                                title: '".$task['task_name'].' '.$task['task_time']."',
                                start: '".date_format(date_create($task['task_date']),'Y-m-d')."',
                                url: '".$url."'
                               },";   
                        }
                    }
                }
                elseif($status === 'my_task')// мои задачи
                {
                    $array_task = $database->db_get_task_author_id($_SESSION['user_id']);
                    
                    foreach($array_task as $task)
                    {
                        if($task['task_contact_id'] !== '0')
                        {
                            $url = '?location=contact_one&id='.$task['task_contact_id'].'&flag=up';
                        }
                        elseif($task['task_contragent_id'] !== '0')
                        {
                            $url = '?location=kontragent_one&id='.$task['task_contragent_id'].'&flag=up';
                        }
                        else
                        {
                            $url = false;
                        }
                        
                        if($url !== false)
                        {
                            print"{
                                title: '".$task['task_name'].' '.$task['task_time']."',
                                start: '".date_format(date_create($task['task_date']),'Y-m-d')."',
                                url: '".$url."'
                               },";   
                        }
                    }
                }
                elseif($status === 'user_one')// задача юриста по id
                {
                    $array_task = $database->db_get_task_author_id($_GET['id']);

                    foreach($array_task as $task)
                    {
                        if($task['task_contact_id'] !== '0')
                        {
                            $url = '?location=contact_one&id='.$task['task_contact_id'].'&flag=up';
                        }
                        elseif($task['task_contragent_id'] !== '0')
                        {
                            $url = '?location=kontragent_one&id='.$task['task_contragent_id'].'&flag=up';
                        }
                        else
                        {
                            $url = false;
                        }
                        
                        if($url !== false)
                        {
                            print"{
                                title: '".$task['task_name'].' '.$task['task_time']."',
                                start: '".date_format(date_create($task['task_date']),'Y-m-d')."',
                                url: '".$url."'
                               },";   
                        }
                    }
                }
                elseif($status === 'contragent_one')// задачи контрагента по id
                {
                    $array_contragent = $database->db_get_task_contragents_id($_GET['id']);
                    
                    foreach($array_contragent as $task)
                    {
                        print"{
                                title: '".$task['task_name']."',
                                start: '".date_format(date_create($task['task_date']),'Y-m-d')."',
                                url: '?location=kontragent_one&id=".$task['task_contragent_id']."&flag=up'
                            },";
                    }
                }
                elseif($status === 'contact_one')// задачи контакта по id
                {
                    $array_contact = $database->db_get_task_contact_id($_GET['id']);
                    
                    foreach($array_contact as $task)
                    {
                        print"{
                                title: '".$task['task_name'].' '.$task['task_time']."',
                                start: '".date_format(date_create($task['task_date']),'Y-m-d')."',
                                url: '?location=contact_one&id=".$task['task_contact_id']."&flag=up'
                            },";
                    }
                }

                ?>
        ]
    });


}();