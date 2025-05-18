<div class="modal fade" id="quizModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<form id="quizForm" action="{{ route('kviz.search') }}" method="POST" class="modal-content">
			@csrf
			<div class="modal-header border-0">
				<h3 class="modal-title fw-bold text-success">Быстрый подбор</h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body quiz-fast">
				<div class="quiz-step active">
					<div class="question mb-5">
						<h5 class="mb-4">1. Какое у тебя настроение?</h5>
						<div class="row g-3">
							<div class="col-6 col-md-4">
								<button type="button" data-question="mood" data-value="sad"  class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="😢">
									<span class="text">Грустное</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/mood/sad.png" alt="">
									</span>
								</button>
								<input type="radio" name="mood" value="sad" hidden>
							</div>
							<div class="col-6 col-md-4">
								<button type="button" data-question="mood" data-value="normal"  class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="😐">
									<span class="text">Нормальное</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/mood/normal.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button type="button" data-question="mood" data-value="happy"  class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="😄">
									<span class="text">Весёлое</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/mood/happy.png" alt="">
									</span>
								</button>
							</div>
						</div>
					</div>
					
					<div class="question mb-5">
						<h5 class="mb-4">2. С кем пойдёшь?</h5>
						<div class="row g-3">
							<div class="col-6 col-md-3">
								<button type="button" data-question="company" data-value="alone"  class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="🧍">
									<span class="text">Один</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/with-who/solo.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-3">
								<button type="button" data-question="company" data-value="family"  class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="👪">
									<span class="text">Семья</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/with-who/family.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-3">
								<button type="button" data-question="company" data-value="date"  class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="💑">
									<span class="text">Свидание</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/with-who/date.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-3">
								<button type="button" data-question="company" data-value="friends"  class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="👫">
									<span class="text">Друзья</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/with-who/friends.png" alt="">
									</span>
								</button>
							</div>
						</div>
					</div>

					<div class="question mb-5">
						<h5 class="mb-4">3. Что хочешь сделать?</h5>
						<div class="row g-3">
							<div class="col-6 col-md-4">
								<button data-question="activity" data-value="eat"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="🍽️">
									<span class="text">Поесть</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/what-want/eat.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button data-question="activity" data-value="walk"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="🚶">
									<span class="text">Погулять</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/what-want/walk.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button data-question="activity" data-value="rest"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="🛋️">
									<span class="text">Отдохнуть</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/what-want/chill.png" alt="">
									</span>
								</button>
							</div>
						</div>
					</div>
				
					<!-- Новый вопрос 4 -->
					<div class="question mb-5">
						<h5 class="mb-4">4. Какой бюджет? (Средний чек) </h5>
						<div class="row g-2">
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="1000"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="💰1">
									<span class="text">до 1000₽</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/budjet/1000rubles.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="1500"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="💰2">
									<span class="text">1000-1500₽</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/budjet/1000-1500.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="2000"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="💰3">
									<span class="text">1500-2000₽</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/budjet/1500-2000.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="3000"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="💰4">
									<span class="text">2000-3000₽</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/budjet/2000-3000.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="3000+"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="💰5">
									<span class="text">от 3000₽</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/budjet/3000+.png" alt="">
									</span>
								</button>
							</div>
						</div>
					</div>
				
					<!-- Новый вопрос 5 -->
					<div class="question">
						<h5 class="mb-4">5. Какая атмосфера?</h5>
						<div class="row g-3">
							<div class="col-6 col-md-4">
								<button data-question="atmosphere" data-value="quiet"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="🔕">
									<span class="text">Тихое место</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/atmosphere/quiet.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button data-question="atmosphere" data-value="noisy"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="🔊">
									<span class="text">Шумное место</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/atmosphere/loud.png" alt="">
									</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button data-question="atmosphere" data-value="any"  type="button" class="btn btn-option w-100 py-3 kviz-answer-btn-js" data-emoji="🤷">
									<span class="text">Без разницы</span>
									<span class="emoji">
										<img class="quiz-fast__emoji-img" src="/img/emodji/atmosphere/not-know.png" alt="">
									</span>
								</button>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer border-0">
				<button type="submit" id="searchButton" class="btn btn-primary px-5 py-2">GO</button>
			</div>
		</form>
	</div>
</div>