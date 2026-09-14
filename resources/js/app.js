window.jokalanteSpeak = function (button) {
    const text = button.getAttribute('data-audio') || '';
    if (!window.speechSynthesis || !text) {
        return;
    }

    window.speechSynthesis.cancel();

    if (button.dataset.playing === '1') {
        button.dataset.playing = '0';
        button.textContent = button.dataset.listenLabel || button.textContent;
        return;
    }

    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = document.documentElement.lang || 'fr';
    utterance.rate = 0.95;
    button.dataset.playing = '1';
    utterance.onend = () => {
        button.dataset.playing = '0';
    };
    window.speechSynthesis.speak(utterance);
};

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {});
    });
}
