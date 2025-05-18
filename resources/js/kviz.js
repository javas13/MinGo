

$(document).ready(function() {

    function selectAnswer(button) {
        const questionGroup = button.closest('.question');
        
        // Снимаем выделение со всех кнопок вопроса
        questionGroup.querySelectorAll('.kviz-answer-btn-js').forEach(btn => {
            btn.classList.remove('selected');
            btn.dataset.selected = "false";
        });
        
        // Выделяем текущую кнопку
        button.classList.add('selected');
        button.dataset.selected = "true";
    }

    $(".kviz-answer-btn-js").click(function(e) {
        selectAnswer(this);
    });
  
    $("#quizForm").submit(function(e) {
      e.preventDefault();
      const loadingOverlay = document.getElementById('loadingOverlay');
      loadingOverlay.style.display = 'flex';
      
      // Отключаем кнопку отправки
      const submitBtn = this.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Обработка...';
  
      // Собираем данные из выбранных ответов
      const formData = new FormData();
      const allQuestions = document.querySelectorAll('.question');
  
      let requiredError = '';
      
      allQuestions.forEach((question, index) => {
          const selectedBtn = question.querySelector('.kviz-answer-btn-js[data-selected="true"]');
          if (!selectedBtn) {
              loadingOverlay.style.display = 'none';
              submitBtn.disabled = false;
              submitBtn.textContent = 'Найти места';
              Swal.fire(
                  'Ошибка!',
                  'Пожалуйста ответьте на все вопросы',
                  'error'
              )
              requiredError = 'error';
              return;
          }
          
          formData.append(selectedBtn.dataset.question, selectedBtn.dataset.value);
      });
  
      if(requiredError != ''){
          return;
      }
  
      $.ajax({
              headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'POST',
              url: '/kviz-search',
              data: formData,
              processData: false,
                contentType: false  
          }).done(function (data) {
              setTimeout(function() {
                  loadingOverlay.style.display = 'none';
                  submitBtn.disabled = false;
                  submitBtn.textContent = 'Найти места';
                  window.location.href = data.data;
              }, 1000);
          }).fail(function () {
              setTimeout(function() {
                  loadingOverlay.style.display = 'none';
                  submitBtn.disabled = false;
                  submitBtn.textContent = 'Найти места';
                  Swal.fire(
                  'Ошибка!',
                  'Неизвестная ошибка',
                  'error'
              )
              }, 1000);
          });
    });
  });