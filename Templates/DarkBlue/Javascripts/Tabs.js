/**
 * Tabs
 * User: Iqbal Maulana
 * Date: 6/27/11
 * Time: 2:03 PM
 */

$(function() {
    $.fn.extend({
        Tab: function(options) {

            var defaults = {
                tabItemClass        : 'tabItem',
                tabContainerClass   : 'tabContainer'
            };

            var options = $.extend(defaults, options);
            var uri     = window.location.href;

            var parts   = uri.split("#!");
            
            if(parts.length > 1) {
                var nav = $('.' + options.tabItemClass + " li a[href='#!" + parts[1] + "']", $(this));
                var tab = $('.' + options.tabContainerClass + ' #' + parts[1], $(this));
                tab.show();
                //alert('.' + options.tabItemClass + ' li a[href=^\#\!' + parts[1] + ']');
                nav.addClass('current');
            }
            else {
                var nav = $('.' + options.tabItemClass + ' li', $(this));
                var tabs = $('.' + options.tabContainerClass + ' .tab', $(this));
                if (tabs.length > 0) {
                    $(tabs[0]).show();
                    $('a', $(nav[0])).addClass('current');
                }
            }
            
            return this.each(function() {
                var o           = options;
                var obj         = $(this);
                var navItems    = $('.' + o.tabItemClass + ' li a', obj);

                navItems.click(function() {
                    var nav = $(this);
                    if (nav.hasClass("current")) return false;

                    var href    = nav.attr("href");
                    var parts   = href.split("#!");
                    var tab     = $('.' + options.tabContainerClass + ' #' + parts[1], obj);

                    if (tab.length <= 0) { alert('Tab not defined!'); return false; }

                    $('.' + options.tabItemClass + ' .current', obj).removeClass("current");
                    $('.' + options.tabContainerClass + ' .tab', obj).hide();
                    nav.addClass('current');
                    tab.show();
                    //return false;
                });
            });
        }
    });
});
