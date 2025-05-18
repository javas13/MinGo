<div class="d-flex flex-column gap-2">
            <a 
                href="https://vk.com/share.php?url={{ url()->current() }}&title={{ urlencode($title ?? 'Посмотрите это!') }}" 
                target="_blank" 
                class="places-results-page__share-button vk"
                >
                <i class="fab fa-vk"></i> Поделиться в VK
            </a>
            <a 
              href="https://t.me/share/url?url={{ url()->current() }}&text={{ urlencode($title ?? 'Интересная ссылка!') }}" 
              target="_blank" 
              class="places-results-page__share-button telegram"
              >
              <i class="fab fa-telegram"></i> Поделиться в Telegram
        </a>
</div>