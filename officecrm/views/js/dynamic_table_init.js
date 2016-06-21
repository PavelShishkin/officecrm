function fnFormatDetails ( oTable, nTr )
{
    var aData = oTable.fnGetData( nTr );
    var sOut = '';
	/* Модальное окно измененеие данных контакта */
	sOut += '<div class="modal fade modal-dialog-center" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog "><div class="modal-content-wrap"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Семенов Федор</h4></div>';
	sOut += '<div class="modal-body"><br/><input type="text"  class="form-control" placeholder="менеджер">';
	sOut += '<br/><input type="text"  class="form-control" placeholder="ООО БезПрав">';
	sOut += '<br/><input type="text"  class="form-control" placeholder="f.semenov@bezprav.ru"><br/>';
	sOut += '<input type="text"  class="form-control" placeholder="8 (962) 463-63-47"><br/></div>';
	sOut += '<div class="modal-footer"><button data-dismiss="modal" class="btn btn-default" type="button">Не сохранять</button> <button class="btn btn-warning" type="button">Сохранить</button></div></div></div></div></div>';
	/* Модальное окно */
	
	sOut += '<div class="col-lg-6" style="padding-top:12px;">';
	sOut += '<aside class="mid-side"><div class="chat-room-head">                          <h3>Заметки</h3></div> <div class="room-desk">                       <div class="room-box">                              <p>Поговорил с Федором, показалось, что настроен решительно.</p>                              <p><span class="text-muted">Автор :</span> Иван Петров | <span class="text-muted">Дата :</span> 21.10.2015</p> </div>                          <div class="room-box">                              <p>Готовит доки.</p>                              <p><span class="text-muted">Автор :</span> Иван Петров | <span class="text-muted">Дата :</span> 27.10.2015</p>                          </div>                          <div class="room-box">                              <p>Сказал, что директор против. Вроде как есть конкуренты.</p>                              <p><span class="text-muted">Автор :</span> Иван Петров | <span class="text-muted">Дата :</span> 02.11.2015</p>                          </div>                          <div class="room-box">                              <p>Все таки работают с нами. Отправил договор</p>                              <p><span class="text-muted">Автор :</span> Иван Петров | <span class="text-muted">Дата :</span> 10.11.2015</p>                          </div>                          <div class="room-box">                              <p>Договор подписали, был на встрече, ждем денег</p>                              <p><span class="text-muted">Автор :</span> Иван Петров | <span class="text-muted">Дата :</span> 23.11.2015</p>                          </div>						  <a class="btn btn-success btn-sm pull-left" href="#">Добавить заметку</a>                      </div>                  </aside>';
	
	
	
	
	sOut += '<div class="col-lg-6" style="padding-top:12px;padding-right:0px;">';
	sOut += '<h4>Примечания</h4>';
	sOut += '';
	sOut += '<button data-toggle="modal" href="#myModal5" type="button" class="btn btn-success btn-sm">Добавить примечание</button>';
	sOut += '</div>';
	
	sOut += '';
	sOut += '';

	
	
	
	
    return sOut;
}

$(document).ready(function() {

    $('#dynamic-table').dataTable( {
        "aaSorting": [[ 4, "desc" ]]
    } );

    /*
     * Insert a 'details' column to the table
     */
    var nCloneTh = document.createElement( 'th' );
    var nCloneTd = document.createElement( 'td' );
    nCloneTd.innerHTML = '<img src="img/details_open.png">';
    nCloneTd.className = "center";

    $('#hidden-table-info thead tr').each( function () {
        this.insertBefore( nCloneTh, this.childNodes[0] );
    } );

    $('#hidden-table-info tbody tr').each( function () {
        this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
    } );

    /*
     * Initialse DataTables, with no sorting on the 'details' column
     */
    var oTable = $('#hidden-table-info').dataTable( {
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 0 ] }
        ],
        "aaSorting": [[1, 'asc']]
    });

    /* Add event listener for opening and closing details
     * Note that the indicator for showing which row is open is not controlled by DataTables,
     * rather it is done here
     */
    $(document).on('click','#hidden-table-info tbody td img',function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTable.fnIsOpen(nTr) )
        {
            /* This row is already open - close it */
            this.src = "img/details_open.png";
            oTable.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src = "img/details_close.png";
            oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
        }
    } );
} );