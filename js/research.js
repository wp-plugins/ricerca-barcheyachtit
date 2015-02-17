jQuery(document).ready(function ($) {
  function DropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('span').eq(1);
    this.opts = this.dd.find('ul.by_dropdown > li');
    this.txt = '';
    this.val = '';
    this.index = -1;
    this.initEvents();
  }
  DropDown.prototype = {
    initEvents : function() {
      var obj = this;

      obj.dd.on('click', function(event){
        $(this).toggleClass('active');
        return false;
      });

      obj.opts.on('click',function(){
        var opt = $(this);
        obj.txt = opt.text();
        obj.val = opt.attr('data-val');
        obj.index = opt.index();
        obj.placeholder.html(obj.txt);
        obj.dd.attr('data-val', obj.val);
      });
    },
    getValue : function() {
      return this.txt;
    },
    getIndex : function() {
      return this.index;
    }
  };

  $(function() {
    $('.by_quando, .by_quanti, .by_barca').each(function() {
      var by_temp = new DropDown( $(this) );
    });

    $('.wrapper-dropdown-by').click(function() {
      $('.wrapper-dropdown-by').not(this).removeClass('active');
    });

    $(document).click(function() {
      $('.wrapper-dropdown-by').removeClass('active');
    });

  });
  //popolazione select periodo
  var tmp = moment().clone();
  var nMesi = 13; //voglio mostrare i prossimi 13 mesi
  var opzioni = [];
  var html = '';

  for (var i=0; i< nMesi; i++)
  {
    var b_text = tmp.format('MMMM') + " " + tmp.format('YYYY'); //testo dell'option, mese e anno formattati

    var b_value = "dal_" + tmp.startOf('month').format("DD_MM_YYYY") +
                "_al_" + tmp.endOf('month').format("DD_MM_YYYY"); //valore dell'option
    
    html += '<li data-val="' + b_value + '"><a href="#">' + b_text + '</a></li>';

    tmp.add('M',1); //prossimo mese
  }
  $('.by_quando .by_dropdown').append(html);

  //Gestion pressione tasto "cerca"
  $( ".by_cerca" ).click(function( event ) {
    event.preventDefault();
    var base = "http://www.bluewago.it/noleggio-barche/#!/ricerca/";
    var _zona = $(".by_dove").attr('data-val');
    var _tipo = $(".by_barca").attr('data-val');
    var _periodo = $(".by_quando").attr('data-val');
    var _posti_letto = $(".by_quanti").attr('data-val');

    var zona = (_zona === '') ? '' : "zona-" + _zona + '/';
    var tipo = (_tipo === '') ? '' : "tipologia-" + _tipo + '/';
    var periodo = (_periodo === '') ? '' : "periodo-" + _periodo + '/';
    var posti_letto = (_posti_letto === '') ? '' : "posti_letto-" + _posti_letto + '/';

    var action = base + zona + tipo + periodo + posti_letto + "?ref=plugin";

    window.open(action,'_blank');
  });

  //Popolazione dinamica select rotte navigazione

  jQuery.extend({
   postJSON: function( url, data, callback) {
      return jQuery.post(url, data, callback, "json");
   }
  });

  
  $.postJSON('http://www.bluewago.it/elenca_zone_navigazione', function(data){
    var html = '';
    var len = data.length;
    for (var i = 0; i< len; i++) {
      html += '<li data-val="' + data[i].replace(/ -? ?/g,"_").toLowerCase() + '"><a href="#">' + data[i] + '</a></li>';
    }
    $('.by_dove .by_dropdown').append(html);
    var by_temp = new DropDown( $('.by_dove') );
  });
});