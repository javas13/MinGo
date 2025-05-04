

$(function () {

    document.querySelector('.header_burger').addEventListener('click', function () {
        if (document.querySelector('#adminmenumain').classList.contains('header_mobile-menu-open')) {
            document.querySelector('#adminmenumain').classList.remove('header_mobile-menu-open');
            document.querySelector('.header_burger').classList.remove('header_burger_active');

        }
        else {
            document.querySelector('#adminmenumain').classList.add('header_mobile-menu-open');
            document.querySelector('.header_burger').classList.add('header_burger_active');

        }
    })

    const mediaMobile = window.matchMedia('(max-width: 782px)')

    if (mediaMobile.matches) {
        let AdminMobilebtns = document.querySelectorAll('.bf-first-item-li');
        for (var i = 0; i < AdminMobilebtns.length; i++) {
            AdminMobilebtns[i].addEventListener('click', function (e) {
                e.target.parentNode.parentNode.childNodes[3].classList.add('bf-first-item-opened');
                if (e.target.document.querySelector('.bf-first-item').classList.contains('bf-first-item-opened')) {

                }
                else {
                    e.target.document.querySelector('.bf-first-item').classList.add('bf-first-item-opened');

                }
            })
        }
    }

    let newsAddSocialBtn = document.querySelector('.is-social-js');

    if(newsAddSocialBtn != null){
        newsAddSocialBtn.addEventListener('click', function (e) {
            if(e.target.checked){
                document.querySelector('.social-options-js').classList.add('news-add-social-visible');
            }
            else{
                document.querySelector('.social-options-js').classList.remove('news-add-social-visible');
            }
        })
    }

    //Чекбокс "Активно"?

    // $('#is_active_btn').change(function() {
    //     if ($(this).is(':checked')) {
    //         $(this).val('1');
    //     } else {
    //         $(this).val('0');
    //     }
    // });


    $('.js-menu')
        .on('mouseenter', function () {
            let menu = $(this);
            setTimeout(function () {
                menu.addClass("opensub");
            }, 200);
        })
        .on('mouseleave', function () {
            let menu = $(this);
            setTimeout(function () {
                menu.removeClass("opensub");
            }, 200);
        });
})
