jQuery(document).ready(function ($) {
  //popolazione select periodo
  var tmp = moment().clone();
  var nMesi = 13; //voglio mostrare i prossimi 13 mesi
  var opzioni = new Array();

  for (var i=0; i< nMesi; i++)
  {
    var text = tmp.format('MMMM') + " " + tmp.format('YYYY'); //testo dell'option, mese e anno formattati

    var value = "dal_" + tmp.startOf('month').format("DD_MM_YYYY") +
                "_al_" + tmp.endOf('month').format("DD_MM_YYYY"); //valore dell'option
    
    opzioni.push({'testo': text, 'valore': value});

    tmp.add('M',1); //prossimo mese
  }

  //Popolazione dinamica select periodo
  var html = '';
  for (var i = 0; i< nMesi; i++) { //prossimi 13 mesi
      html += '<option value="' + opzioni[i].valore + '">' + opzioni[i].testo + '</option>';
  }
  $('#by_periodo').append(html);


  //Gestion pressione tasto "cerca"
  $( "#by_cerca" ).click(function( event ) {
    var base = "http://www.barcheyacht.it/noleggio-barche/#!/ricerca/";
    var _zona = $("#by_dove").val();
    var _tipo = $("#by_tipo").val();
    var _periodo = $("#by_periodo").val();
    var _posti_letto = $("#by_posti_letto").val();

    var zona = (_zona == '') ? '' : "zona-" + _zona + '/';
    var tipo = (_tipo == '') ? '' : "tipologia-" + _tipo + '/';
    var periodo = (_periodo == '') ? '' : "periodo-" + _periodo + '/';
    var posti_letto = (_posti_letto == '') ? '' : "posti_letto-" + _posti_letto + '/';

    var action = base + zona + tipo + periodo + posti_letto;

    window.open(
      action,
      '_blank' // <- This is what makes it open in a new window.
    );
  });

  //Popolazione dinamica select rotte navigazione

  jQuery.extend({
   postJSON: function( url, data, callback) {
      return jQuery.post(url, data, callback, "json");
   }
  });

  
  $.postJSON('http://www.barcheyacht.it/elenca_zone_navigazione', function(data){
    console.log(data);
    var html = '';
    var len = data.length;
    for (var i = 0; i< len; i++) {
        html += '<option value="' + data[i].replace(/ /g,"_").toLowerCase() + '">' + data[i] + '</option>';
    }
    console.log(html);
    $('#by_dove').append(html);
  });
});