// http://paulirish.com/2011/requestanimationframe-for-smart-animating/
// http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating

// requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel

// MIT license

(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame']
            || window[vendors[x]+'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
                timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

// progressive-image.js
if (window.addEventListener && window.requestAnimationFrame && document.getElementsByClassName) window.addEventListener('load', function() {

    // start
    var pItem = document.getElementsByClassName('wpsol-lazy'), timer;


    window.addEventListener('scroll', scroller, false);
    window.addEventListener('resize', scroller, false);
    inView(true);


    // throttled scroll/resize
    function scroller(e) {

        timer = timer || setTimeout(function() {
            timer = null;
            requestAnimationFrame(function() {
                inView(false);
            });
        }, 300);

    }


    // image in view?
    function inView(first_screen) {

        var wT = window.pageYOffset, wB = wT + (window.innerHeight*2), cRect, pT, pB, p = 0;
        while (p < pItem.length) {
            hidden = false;
            cRect = pItem[p].getBoundingClientRect();
            pT = wT + cRect.top;
            pB = pT + cRect.height;
            // Lazy loading with hidden item
            if (cRect.top === 0 && cRect.height === 0 && cRect.width === 0) {
                hidden = true;
            }

            if ((cRect.top === 0 && cRect.height === 0 && cRect.width === 0) ||
                (wT < pB && wB > pT)) {
                loadFullImage(pItem[p], hidden, first_screen);
                pItem[p].classList.remove('wpsol-lazy');
            }
            else p++;

        }

    }


    // replace with full image
    function loadFullImage(item, hidden, first_screen) {
        if (!item) return;

        if (item.complete) addImg();
        else item.onload = addImg;

        // replace image
        function addImg() {
            if (item.dataset.wpsollazySrcset) {
                item.srcset = item.dataset.wpsollazySrcset;
            }

            if (item.dataset.wpsollazySrc) {
                item.src = item.dataset.wpsollazySrc;
            }

            item.onload = function() {
                if (first_screen) {
                    // Remove class in first screen view
                    item.classList.remove('wpsol-lazy-hidden');
                    item.classList.add('wpsol-first-loaded');
                } else {
                    // the image is ready remove|add class
                    item.classList.add('wpsol-lazy-loaded');

                    if (hidden) {
                        item.classList.remove('wpsol-lazy-hidden');
                    } else {
                        item.addEventListener('animationend', function(e) {
                            e.target.classList.remove('wpsol-lazy-hidden');
                        });
                    }
                }
            };

        }
    }

}, false);