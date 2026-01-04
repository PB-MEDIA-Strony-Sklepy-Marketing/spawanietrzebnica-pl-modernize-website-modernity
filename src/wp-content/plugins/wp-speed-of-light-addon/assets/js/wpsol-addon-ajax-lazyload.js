wpsolajaxloadlazy = function () {
    // start
    var pItem = document.getElementsByClassName('wpsol-lazy');

    setTimeout(function() {
        inView(true);
    }, 500);


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
};

jQuery(document).ajaxComplete(function () {
    wpsolajaxloadlazy();
});