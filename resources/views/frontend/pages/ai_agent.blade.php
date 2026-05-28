@extends('frontend.master_dashboard')
@section('main')


<!--===== HEADER AREA =====-->
<div class="about-header-area" style=" background: var(
        --Linner-Color,
        linear-gradient(268deg, #408bff 0.24%, #0a18a1 98.24%)
    )">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto text-center">
                <div class="about-inner-header heading9">
                    <h3 style="font-family: 'Cairo', sans-serif;color:white">تواصل عبر الذكاء الاصطناعي</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===== CHATBOT AREA =====-->
<div class="chatbot-container">
    <div class="chat-header">
        <h5>🤖 المساعد الذكي</h5>
    </div>

    <div class="chat-body" id="chatBody">
        <div class="message bot-message">
            مرحباً 👋، كيف أقدر أساعدك اليوم؟
        </div>
    </div>

    <div class="chat-footer">
        <form id="chatForm" onsubmit="sendMessage(event)">
            <input type="text" id="userMessage" placeholder="اكتب رسالتك هنا..." autocomplete="off" required>
            <button type="button" id="voiceBtn" title="تسجيل صوت">🎤</button>
            <button type="submit">إرسال</button>
        </form>
    </div>
</div>

<!-- مكتبة Markdown -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
/* ======= تصميم الشات ======= */
.chatbot-container {
    max-width: 800px;
    margin: 20px auto;
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    height: 550px; /* ثابت متوسط مناسب */
}

.chat-body {
    flex: 1;                 /* ياخذ المساحة المتبقية */
    padding: 15px;
    overflow-y: auto;        /* تمرير الرسائل فقط */
    background: #f9f9f9;
    display: flex;
    flex-direction: column;
}

.chat-footer {
    border-top: 1px solid #ddd;
    background: #fff;
    padding: 10px;
    position: sticky;
    bottom: 0;
}



.chat-header {
    background: var(--primary-color, #ED7032);
    color: #fff;
    padding: 15px;
    text-align: center;
    font-family: 'Cairo', sans-serif;
    font-size: 18px;
    font-weight: bold;
}



.message {
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 12px;
    margin: 8px 0;
    font-family: 'Cairo', sans-serif;
    font-size: 15px;
    word-wrap: break-word;
}

.bot-message { background: #ececec; color: #333; align-self: flex-start; }
.user-message { background: var(--primary-color, #ED7032); color: #fff; align-self: flex-end; }

.chat-footer { display: flex; border-top: 1px solid #ddd; background: #fff; }
.chat-footer form { display: flex; width: 100%; align-items: center; }
.chat-footer input { flex: 1; border: none; padding: 12px 15px; font-family: 'Cairo', sans-serif; font-size: 15px; }
.chat-footer input:focus { outline: none; }
#voiceBtn { background: #555; color: #fff; border: none; border-radius: 50%; width: 40px; height: 40px; margin: 0 5px; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
#voiceBtn.recording { background: red; animation: pulse 1s infinite; }
@keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.6; } 100% { opacity: 1; } }

/* مؤشر الكتابة المتحرك */
.typing { display: flex; align-items: center; gap: 5px; }
.typing-dot { width: 8px; height: 8px; background: #333; border-radius: 50%; animation: blink 1.4s infinite both; }
.typing-dot:nth-child(1) { animation-delay: 0s; }
.typing-dot:nth-child(2) { animation-delay: 0.2s; }
.typing-dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes blink { 0%, 80%, 100% { opacity: 0; } 40% { opacity: 1; } }

.chat-footer button[type="submit"] { background: var(--primary-color, #ED7032); color: #fff; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; transition: background 0.3s; }
.chat-footer button[type="submit"]:hover { background: #d95d21; }

@media (max-width: 768px) {
    .chatbot-container {
        max-width: 100%;
        max-height: 500px;  /* أصغر في الموبايل */
        min-height: 500px;
        border-radius: 0;
    }
}
</style>

<script>
function sendMessage(event) {
    if(event) event.preventDefault();
    let input = document.getElementById("userMessage");
    let message = input.value.trim();
    if(message === "") return;

    let chatBody = document.getElementById("chatBody");

    // عرض رسالة المستخدم
    let userMsg = document.createElement("div");
    userMsg.classList.add("message", "user-message");
    userMsg.textContent = message;
    chatBody.appendChild(userMsg);
    input.value = "";
    chatBody.scrollTop = chatBody.scrollHeight;

    // مؤشر الكتابة المتحرك
    let typingMsg = document.createElement("div");
    typingMsg.classList.add("message", "bot-message", "typing");
    typingMsg.id = "typingMsg";
    typingMsg.innerHTML = 'المساعد الذكي <span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
    chatBody.appendChild(typingMsg);
    chatBody.scrollTop = chatBody.scrollHeight;

    // إرسال السؤال للـ AI
    fetch("/ai-agent/ask", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ question: message })
    })
    .then(res => res.json())
    .then(data => {
        typingMsg.remove();

        let botMsg = document.createElement("div");
        botMsg.classList.add("message", "bot-message");

        let answerText = data.answer || "لا يوجد رد من المساعد الذكي";
        botMsg.innerHTML = marked.parse(answerText);

        botMsg.querySelectorAll('a').forEach(a => a.setAttribute('target', '_blank'));

        chatBody.appendChild(botMsg);
        chatBody.scrollTop = chatBody.scrollHeight;
    });
}

// تسجيل الصوت Start/Stop وإرسال تلقائي
let recognition;
const voiceBtn = document.getElementById("voiceBtn");
let isRecording = false;
let lastTranscript = "";

if ('webkitSpeechRecognition' in window) {
    recognition = new webkitSpeechRecognition();
    recognition.lang = "ar-SA";
    recognition.continuous = false;

    recognition.onresult = function(event) {
        lastTranscript = event.results[0][0].transcript;
    };

    recognition.onstart = function() {
        voiceBtn.classList.add("recording");
        isRecording = true;
    };

    recognition.onend = function() {
        voiceBtn.classList.remove("recording");
        isRecording = false;

        if(lastTranscript !== "") {
            const input = document.getElementById("userMessage");
            input.value = lastTranscript;
            sendMessage(new Event('submit'));
            lastTranscript = "";
        }
    };

    voiceBtn.addEventListener("click", () => {
        if(!isRecording) recognition.start();
        else recognition.stop();
    });
} else {
    voiceBtn.disabled = true;
    voiceBtn.title = "المتصفح لا يدعم التسجيل الصوتي";
}
</script>

@endsection
