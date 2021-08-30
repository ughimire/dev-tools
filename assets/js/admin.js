/*!
  * @package umeshghimire
  */

 (function($){
    'use strict';

    var winWidth, winHeight, DevTools;
    var backend_document = $(document);
    var DevTools = {

        //Custom Snipits goes here
        Snipits: {

            Variables: function(){
                
                winWidth = $(window).width();
                winHeight = $(window).height();

            },

            AddProgress: function(details){

                var sidebarind = details.sidebarind;
                var widgetind = details.widgetind;
                var sidebarlen = details.sidebarlen;
                var widgetlen = details.widgetlen;

                var total_widgets = sidebarlen*widgetlen;
                var added_widgets = widgetind;
                if(sidebarind>1){
                    added_widgets = (sidebarind*widgetlen)+widgetind;
                }
                var percentage = Math.floor( (added_widgets/total_widgets) * 100 );
                var percentage_text = percentage+'% Completed';
                $('.widget-progress-bar').css('width', percentage+'%' );
                $('.widget-progress-wrapper .percentage').text(percentage_text);

                if(total_widgets==added_widgets){
                    $('body').addClass('dg-widget-completed');
                    $('body').removeClass('dg-adding-widget');
                }

            },

            saveOrder: function($sidebar_id){

                var order_ajax = {
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'widgets-order',
                        savewidgets: $('#_wpnonce_widgets').val(),
                        sidebars: []
                    },
                    success: function(response){
                        console.log('success ordering widget response');
                        console.log(response);
                    }
                };
                $.ajax(order_ajax)
                .fail(function() {
                    console.log("order error");
                });

            },

            WidgetsLoop: function(data, details){
                
                var __this = DevTools;
                var snipits = __this.Snipits;
                var $widgets = $('#widget-list > .widget');
                var $sidebars = $('#widgets-right .widgets-sortables');
                
                if(typeof details.widgetlen=="undefined"){
                    details.widgetlen=$widgets.length;
                }
                if(details.widgetlen==details.widgetind){
                    details.sidebarind += 1;
                    details.widgetind = 0;
                    console.log('Change Sidebar');
                }

                if(typeof details.sidebarlen=="undefined"){
                    details.sidebarlen=$sidebars.length;
                }
                if(details.sidebarlen==details.sidebarind){
                    //Ajax loop completed
                    alert('Widget adding Completed');
                    return;
                }               

                var sidebar_id = $sidebars.eq(details.sidebarind).attr('id');
                var $widget_form = $widgets.eq(details.widgetind).find('form');
                var widgetbase = $widget_form.find('.id_base').val();
                var form_values = $widget_form.serialize();
               
                data.sidebar_id = sidebar_id;
                data.basename = widgetbase;
                data.form_values = form_values;
                snipits.AddWidget( data, details);

            },

            AddWidget: function(data, details){
                details.widgetind +=  1;
                var __this = DevTools;
                var snipits = __this.Snipits;
                data.widget_index = details.widgetind;
                data.action = 'add_single_widget';
                var ajaxargs = {
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                    success: function(response){
                        if(response.success){
                            console.log( response.data.sidebar_id+':'+response.data.widget_id);
                            snipits.AddProgress(details);
                            snipits.WidgetsLoop(data, details);
                        }
                    }
                };
                $.ajax(ajaxargs)
                .fail(function(response) {
                    console.warn("Error adding widget.");
                    console.log(response);
                });
            },

            AddAllWidgets: function(evt){

                var __this = DevTools;
                var snipits = __this.Snipits;

                var data = {
                    'addwidget': $(this).val(),
                };
                var widgets = {
                    sidebarind:0,
                    widgetind:0,
                };
                $('body').addClass('dg-adding-widget')
                snipits.WidgetsLoop( data, widgets);
                
            },

            ClearWidgets: function(){
                var nonce_val = $(this).val();
                var ajaxargs = {
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        'action': 'clear_all_widgets',
                        'clearwidgets': nonce_val,
                    },
                    success: function(response){
                        console.log('clear widget success');
                        if(response.success){
                            alert(response.data.message);
                        }
                    }
                };
                $.ajax(ajaxargs)
                .fail(function(error) {
                    console.warn("Ajax error on clearing widgets.");
                    console.log(error);
                });

            },

        },     

        Events: function(){

            var __this = DevTools;
            var snipits = __this.Snipits;

            var all_widgets = snipits.AddAllWidgets;
            $(document).find('.dg-add-widgets').on('click', all_widgets);

            var clear_widgets = snipits.ClearWidgets;
            $(document).find('.dg-clear-widgets').on('click', clear_widgets);

        },

        Ready: function(){

            var __this = DevTools;
            var snipits = __this.Snipits;

            // Set variables
            snipits.Variables();

            //This is newsmagazine functions
            __this.Events();

        },

        Load: function(){

        },

        Resize: function(){

        },

        Scroll: function(){

        },

        Init: function(){

            var __this = DevTools;
            var docready = __this.Ready;
            var winload = __this.Load;
            var winresize = __this.Resize;
            var winscroll = __this.Scroll;
            backend_document.ready(docready);
            $(window).load(winload);
            $(window).scroll(winscroll);
            $(window).resize(winresize);

        },

     };
     
     DevTools.Init();

})(jQuery);
