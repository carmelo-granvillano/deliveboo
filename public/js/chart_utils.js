'use strict';

window.chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
};

(function(global) {
    var MONTHS = [
        'Gennaio',
        'Febbraio',
        'Marzo',
        'Aprile',
        'Maggio',
        'Giugno',
        'Luglio',
        'Agosto',
        'Settembre',
        'Ottobre',
        'Novembre',
        'Dicembre'
    ];
    var COLORS = [
        '#4dc9f6',
        '#f67019',
        '#f53794',
        '#537bc4',
        '#acc236',
        '#166a8f',
        '#00a950',
        '#58595b',
        '#8549ba'
    ];

    var formatMont = [];

    var Samples = global.Samples || (global.Samples = {});
    var Color = global.Color;
    Samples.utils = {
        // Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
        srand: function(seed) {
            this._seed = seed;
        },

        rand: function(min, max) {
            var seed = this._seed;
            min = min === undefined ? 0 : min;
            max = max === undefined ? 1 : max;
            this._seed = (seed * 9301 + 49297) % 233280;
            return min + (this._seed / 233280) * (max - min);
        },
        numbers: function(config) {
            var cfg = config || {};
            var min = cfg.min || 0;
            var max = cfg.max || 1;
            var from = cfg.from || {};
            var count = cfg.count || 8;
            var decimals = cfg.decimals || 8;
            var continuity = cfg.continuity || 1;
            var dfactor = Math.pow(10, decimals) || 0;
            var data = {};
            var i, obj = {};
            /*
            for (i = 0, check = 1; check <= count; check++) {
                //+ this.rand(min, max);
                if (check < start){
                  //console.log(i);
                  data.push(0);
                } else {
                  value = (from[i] || 0);
                  console.log(value);
                  data.push(value);
                  i++;
                }
                //console.log(value);
                
                
                console.log(value, start);
                if (this.rand() <= continuity) {
                    data.push(Math.round(dfactor * value) / dfactor);
                } else {
                    data.push(null);
                }
            }
            */
            for(i = 0; i < count; i++){
                if(from[i + 1]){
                    obj[MONTHS[i]] = from[i + 1];
                } else {
                    obj[MONTHS[i]] = 0;
                }
            }

            formatMont.forEach((ele) => data[ele] = obj[ele] );

            return data;
        },
        labels: function(config) {
            var cfg = config || {};
            var min = cfg.min || 0;
            var max = cfg.max || 100;
            var count = cfg.count || 8;
            var step = (max - min) / count;
            var decimals = cfg.decimals || 8;
            var dfactor = Math.pow(10, decimals) || 0;
            var prefix = cfg.prefix || '';
            var values = [];
            var i;

            for (i = min; i < max; i += step) {
                values.push(prefix + Math.round(dfactor * i) / dfactor);
            }

            return values;
        },
        months: function(config) {
            var cfg = config || {};
            var count = cfg.count || 12;
            var section = cfg.section;
            var current = cfg.current || 0;
            var values = [];
            var i, value;
            /*
            for (i = 0; i < count; ++i) {
                value = MONTHS[Math.ceil(i) % 12];
                values.push(value.substring(0, section));
            }
            */

            const currentMonth = current + 1;
            const months = [...MONTHS];

            let formatMonths = months.splice(currentMonth);

            months.unshift(...formatMonths);

            formatMont = months;

            return months;
        },
        color: function(index) {
            return COLORS[index % COLORS.length];
        },

        //transparentize: function(color, opacity) {
        //  var alpha = opacity === undefined ? 0.5 : 1 - opacity;
        //  return ColorO(color).alpha(alpha).rgbString();
        //}
        transparentize: function (r, g, b, alpha) {
              const a = (1 - alpha) * 255;
              const calc = x => Math.round((x - a)/alpha);

              return `rgba(${calc(r)}, ${calc(g)}, ${calc(b)}, ${alpha})`;
            }
    

    };
    // DEPRECATED
    window.randomScalingFactor = function() {
        return Math.round(Samples.utils.rand(-100, 100));
    };
    // INITIALIZATION
    Samples.utils.srand(Date.now());

    // Google Analytics
    /* eslint-disable */
    if (document.location.hostname.match(/^(www\.)?chartjs\.org$/)) {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-28909194-3', 'auto');
        ga('send', 'pageview');
    }
    /* eslint-enable */

}(this));