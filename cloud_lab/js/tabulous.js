/*!
 * strength.js
 * Original author: @aaronlumsden
 * Further changes, comments: @aaronlumsden
 * Licensed under the MIT license
 */
;(function ( $, window, document, undefined ) {

    var pluginName = "tabulous",
        defaults = {
            effect: 'slideLeft'
        };

       // $('<style>body { background-color: red; color: white; }</style>').appendTo('head');

    function Plugin( element, options ) {
        this.element = element;
        this.$elem = $(this.element);
        this.options = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {

        init: function() {
            var links = this.$elem.find('.'+this.$elem.attr('id')+'-a');
            var firstchild = this.$elem.find('li:first-child').find('.'+this.$elem.attr('id')+'-a');
            //var lastchild = this.$elem.find('li:last-child').after('<span class="tabulousclear"></span>');
            if (this.options.effect == 'slideLeft') {
                 tab_content = this.$elem.find('.tab').not(':first').not(':nth-child(1)').addClass('hideright');
                 tab_content = this.$elem.find('.subtab').not(':first').not(':nth-child(1)').addClass('hideright');
            }

            //var firstdiv = this.$elem.find('#tabs_container');
            //var firstdivheight = firstdiv.find('div:first').height();

            //var alldivs = this.$elem.find('div:first').find('.tabs'+'.tabss');

            //alldivs.css({'position': 'absolute','top':'40px'});
			
            //firstdiv.css('height',firstdivheight+'px');

            firstchild.addClass('tabulous_active');

            links.bind('click', {myOptions: this.options}, function(e) {
                e.preventDefault();

                var $options = e.data.myOptions;
                var effect = $options.effect;

                var mythis = $(this);
                var thisform = mythis.parent().parent().parent();
                var thislink = mythis.attr('href');
				var thiscontent = thisform.find('div'+thislink);
                var firstdiv = thisform.find('div:first');

                firstdiv.addClass('transition');
                mythis.parent().parent().children().children('a').removeClass('tabulous_active');
                mythis.addClass('tabulous_active');
                //thisdivwidth = thisform.find('div'+thislink).height();

                if (effect == 'slideLeft') {
                    thiscontent.parent().children('div').removeClass('show hideleft hideright').addClass('make_transist');
					thiscontent.prevAll().addClass('hideleft');
					thiscontent.nextAll().addClass('hideright');
                    thiscontent.addClass('make_transist').addClass('show');
                }
                //firstdiv.css('height',thisdivwidth+'px');             
            });
        },
        yourOtherFunction: function(el, options) {
            // some logic
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            new Plugin( this, options );
        });
    };

})( jQuery, window, document );


