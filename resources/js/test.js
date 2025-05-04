document.addEventListener("DOMContentLoaded", function () {

class Question {

    constructor(id, name, answers, number, progress) {
      this.id = id;
      this.name = name;
      this.answers = answers;
      this.progress = progress;
    }
  
  }
  
  class Answer {
  
    constructor(name, price, id) {
      this.id = id;
      this.name = name;
      this.price = price;
    }
  
  }
  
  class ClientAnswer {
  
    constructor(questId, answerId) {
      this.questId = questId;
      this.answerId = answerId;
    }
  
}

let answerFirstQuest1 = new Answer("Лендинг", "15000", 0);
let answerSecondQuest1 = new Answer("Корпоративный сайт", "65000", 1);
let answerThirdQuest1 = new Answer("Интернет-каталог", "95000", 2);
let answerFourQuest1 = new Answer("Интернет-магазин", "135000", 3);
let answerFiveQuest1 = new Answer("Сайт медицинской клиники", "80000", 4);
let answerSixQuest1 = new Answer("Индивидуальное решение", "105000", 5);
let answerSevenQuest1 = new Answer("Пока не определился(-ась)", "30000", 6);

let answerFirstQuest2 = new Answer("Нет", "5000", 0);
let answerSecondQuest2 = new Answer("У меня есть макет дизайна, нужна только разработка", "10000", 1);
let answerThirdQuest2 = new Answer("Нужно шаблонное решение", "5000", 2);
let answerFourQuest2 = new Answer("Мне нужен уникальный дизайн", "20000", 3);

let answerFirstQuest3 = new Answer("Нет", "10000", 0);
let answerSecondQuest3 = new Answer("Да", "5000", 1);

let answerFirstQuest4 = new Answer("Нет", "0", 0);
let answerSecondQuest4 = new Answer("Да", "5000", 1);

let totalSum = 0;

let firstQuestionAnswers = [answerFirstQuest1, answerSecondQuest1, answerThirdQuest1, answerFourQuest1, answerFiveQuest1, answerSixQuest1, answerSevenQuest1];
let secondQuestionAnswers = [answerFirstQuest2, answerSecondQuest2, answerThirdQuest2, answerFourQuest2];
let thirdQuestionAnswers = [answerFirstQuest3, answerSecondQuest3];
let fourQuestionAnswers = [answerFirstQuest4, answerSecondQuest4];

let questionFirst = new Question(1, "Какой вид спорта вас интересует? (Можно выбрать несколько вариантов)", firstQuestionAnswers, 5);
let questionSecond = new Question(2, "В каком регионе вы планируете проводить сборы? (Можно выбрать несколько вариантов)", secondQuestionAnswers, 25);
let questionThird = new Question(3, "Какие спортивные объекты должны быть на базе? (Можно выбрать несколько вариантов)", thirdQuestionAnswers, 50);
let questionFour = new Question(4, "Требуются ли восстановительные и медицинские услуги? (Можно выбрать несколько вариантов)", thirdQuestionAnswers, 75);
let questionFive = new Question(5, "Какой у вас бюджет на человека в сутки?)", thirdQuestionAnswers, 75);
let questionSix = new Question(6, "Укажите желаемые даты проведения сборов", thirdQuestionAnswers, 75);
let questionSeven = new Question(7, "Какой способ оплаты предпочтителен?", thirdQuestionAnswers, 75);
let questionEight = new Question(8, "Укажите предполагаемую продолжительность пребывания (в днях).", thirdQuestionAnswers, 75);
let questionNine = new Question(9, "Укажите количество участников и тренеров, которые планируют участие в сборах.", thirdQuestionAnswers, 75);
let questionTen = new Question(10, "Чтобы получить подборку идеально подходящих баз, оставьте свои контактные данные:", thirdQuestionAnswers, 75);

let firstAnswerClient = [];
let secondAnswerClient = [];
let thirdAnswerClient = [];
let fourAnswerClient = [];
let fiveAnswerClient = [];
let sixAnswerClient = [];
let sevenAnswerClient = [];
let eightAnswerClient = [];
let nineAnswerClient = [];
let tenAnswerClient = [];

let questionNumber = 1;

let questions = [questionFirst, questionSecond, questionThird, questionFour];

function init() {
    let questiionName = questions[0].name;
    let questiionId = questions[0].id;
    document.querySelector('.kviz-window__question-name-js').innerHTML = questiionName;
    document.querySelector('.kviz-window__question-number-js').innerHTML = questiionId;
}

function answer(number) {
    return number * number;
}

$('.kviz_btn-js').click(function() {
    init();
});



$('.kviz-form-js').submit(function(e) {
  
  let questionNumber = document.querySelector('.kviz-window__question-number-js').innerHTML;
  document.getElementById('loader').style.display = 'flex';
  let bodyForAnswers = $('.kviz-window__asnwers-js');
  if($('.kviz-form-js').serializeArray().length == 0){
    document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
    Swal.fire(
      'Ошибка!',
      'Вы не заполнили данные! Заполните данные и нажмите продолжить!',
      'error'
    )
    e.preventDefault();
  }
  else if(questionNumber == 1){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 2 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        firstAnswerClient = dataFromForm;
        console.log(dataFromForm);
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = questionSecond.name;
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__question-number-js').innerHTML = '2';
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
  else if(questionNumber == 2){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 3 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        secondAnswerClient = dataFromForm;
        console.log(dataFromForm);
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = questionThird.name;
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__question-number-js').innerHTML = '3';
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
  else if(questionNumber == 3){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 4 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        thirdAnswerClient = dataFromForm;
        console.log(dataFromForm);
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = questionFour.name;
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__question-number-js').innerHTML = '4';
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
  else if(questionNumber == 4){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 5 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        fourAnswerClient = dataFromForm;
        console.log(dataFromForm);
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = questionFive.name;
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__question-number-js').innerHTML = '5';
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
  else if(questionNumber == 5){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 6 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        fiveAnswerClient = dataFromForm;
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = questionSix.name;
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__question-number-js').innerHTML = '6';
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
  else if(questionNumber == 6){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 7 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        sixAnswerClient = dataFromForm;
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = questionSeven.name;
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__question-number-js').innerHTML = '7';
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
  else if(questionNumber == 7){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 8 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        sevenAnswerClient = dataFromForm;
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = questionEight.name;
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__question-number-js').innerHTML = '8';
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
  else if(questionNumber == 8){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 9 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        eightAnswerClient = dataFromForm;
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = questionNine.name;
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__question-number-js').innerHTML = '9';
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
  else if(questionNumber == 9){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 10 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        nineAnswerClient = dataFromForm;
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = questionTen.name;
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__question-number-js').innerHTML = '10';
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
  else if(questionNumber == 10){
    $.ajax({
      type: 'Get',
      url: '/get-answers',
      data: { questionId: 11 },
    }).done(function (data) {
      setTimeout(function() {
        document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
        let dataFromForm = $('.kviz-form-js').serializeArray();
        tenAnswerClient = dataFromForm;
        document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
        document.querySelector('.kviz-window__question-name-js').innerHTML = 'Отлично! Мы подготовим подборку спортивных баз, которые идеально подходят под ваши запросы. Нажмите кнопку, чтобы скачать подборку баз.';
        bodyForAnswers.append(data.html);
        document.querySelector('.kviz-window__top-js').classList.remove('active');
        document.querySelector('.kviz-window__form-btn-js').classList.remove('active');
        //ОТПРАВКА ОТВЕТОВ ПОЛЬЗОВАТЕЛЯ В ТЕЛЕГУ
        $.ajax({
          type: 'Post',
          url: '/kvizSendFeedbackTelegram',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {
            firstAnswer: firstAnswerClient,
            secondAnswer: secondAnswerClient,
            thirdAnswer: thirdAnswerClient,
            fourAnswer: fourAnswerClient,
            fiveAnswer: fiveAnswerClient,
            sixAnswer: sixAnswerClient,
            sevenAnswer: sevenAnswerClient,
            eightAnswer: eightAnswerClient,
            nineAnswer: nineAnswerClient, 
            tenAnswer: tenAnswerClient,},
        }).done(function (data) {
          setTimeout(function() {
            document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
          }, 1000); // Задержка
        }).fail(function () {
          Swal.fire(
            'Ошибка!',
            'Неизвестная ошибка',
            'error'
          )
        });
        //КОНЕЦ ОТПРАВКИ ОТВЕТОВ ПОЛЬЗОВАТЕЛЯ В ТЕЛЕГУ
        $('.kviz-window__bases-download-js').click(function() {
          document.getElementById('loader').style.display = 'flex';
          $.ajax({
            type: 'Get',
            url: '/get-bases',
            data: { firstAnswer: firstAnswerClient,
               secondAnswer: secondAnswerClient,
               thirdAnswer: thirdAnswerClient,
               fourAnswer: fourAnswerClient,
               fiveAnswer: fiveAnswerClient,
               sixAnswer: sixAnswerClient,
               sevenAnswer: sevenAnswerClient,
               eightAnswer: eightAnswerClient,
               nineAnswer: nineAnswerClient, 
               tenAnswer: tenAnswerClient,},
          }).done(function (data) {
            setTimeout(function() {
              document.getElementById('loader').style.display = 'none'; // Скрываем индикатор после завершения
              if(data.basesCount == 0){
                let kvizWindow = document.querySelector('.kviz-window-js');
                  if(kvizWindow != null){
                      kvizWindow.classList.remove('open');
                      document.documentElement.style.overflow = 'visible';
                      document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
                      document.querySelector('.kviz-window__question-name-js').innerHTML = '';
                }
                Swal.fire({
                  title: "Базы не найдены",
                  icon: "fail",
                  html: `
                  К сожалению мы не нашли базы по вашим ответам( Вы можете оставить заявку и мы обязательно подберём вам базу!</br>
                  <a class="kviz-window__alert-link" href="/contacts" autofocus>Оставить заявку</a>
                `,
                  showCancelButton: true,
                  showConfirmButton: false,
                  focusConfirm: false,
                  confirmButtonAriaLabel: "Thumbs up, great!",
                  cancelButtonText: "Закрыть",
                  cancelButtonAriaLabel: "Thumbs down"
                });
              }
              else{
                let kvizWindow = document.querySelector('.kviz-window-js');
                  if(kvizWindow != null){
                      kvizWindow.classList.remove('open');
                      document.documentElement.style.overflow = 'visible';
                      document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
                      document.querySelector('.kviz-window__question-name-js').innerHTML = '';
                }
                window.location = data.url;
              }
            }, 1000); // Задержка
          }).fail(function () {
            document.getElementById('loader').style.display = 'none';
            let kvizWindow = document.querySelector('.kviz-window-js');
                  if(kvizWindow != null){
                      kvizWindow.classList.remove('open');
                      document.documentElement.style.overflow = 'visible';
                      document.querySelector('.kviz-window__asnwers-js').innerHTML = '';
                      document.querySelector('.kviz-window__question-name-js').innerHTML = '';
                }
            Swal.fire(
              'Ошибка!',
              'Неизвестная ошибка',
              'error'
            )
          });
        });
      }, 1000); // Задержка
    }).fail(function () {
      Swal.fire(
        'Ошибка!',
        'Неизвестная ошибка',
        'error'
      )
    });
    e.preventDefault();
  }
});


});
