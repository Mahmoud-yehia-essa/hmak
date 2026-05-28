@extends('frontend.master_dashboard')
@section('main')

<!--===== HEADER AREA =====-->
<div class="about-header-area" style="background-color: #ED7032">
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

<!-- إضافة مكتبة Markdown -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
    .chatbot-container { max-width: 800px; margin: 30px auto; background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; flex-direction: column; height: 75vh; }
    .chat-header { background: var(--primary-color, #ED7032); color: #fff; padding: 15px; text-align: center; font-family: 'Cairo', sans-serif; font-size: 18px; font-weight: bold; }
    .chat-body { flex: 1; padding: 15px; overflow-y: auto; background: #f9f9f9; display: flex; flex-direction: column; }
    .message { max-width: 80%; padding: 10px 15px; border-radius: 12px; margin: 8px 0; font-family: 'Cairo', sans-serif; font-size: 15px; word-wrap: break-word; }
    .bot-message { background: #ececec; color: #333; align-self: flex-start; }
    .user-message { background: var(--primary-color, #ED7032); color: #fff; align-self: flex-end; }
    .chat-footer { display: flex; border-top: 1px solid #ddd; background: #fff; }
    .chat-footer form { display: flex; width: 100%; align-items: center; }
    .chat-footer input { flex: 1; border: none; padding: 12px 15px; font-family: 'Cairo', sans-serif; font-size: 15px; }
    .chat-footer input:focus { outline: none; }
    #voiceBtn { background: #555; color: #fff; border: none; border-radius: 50%; width: 40px; height: 40px; margin: 0 5px; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
    #voiceBtn.recording { background: red; animation: pulse 1s infinite; }
    @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.6; } 100% { opacity: 1; } }
    .chat-footer button[type="submit"] { background: var(--primary-color, #ED7032); color: #fff; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; transition: background 0.3s; }
    .chat-footer button[type="submit"]:hover { background: #d95d21; }
    @media (max-width: 768px) { .chatbot-container { max-width: 100%; height: 80vh; border-radius: 0; } }
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

    // إرسال السؤال للـ AI عبر AJAX
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
        let botMsg = document.createElement("div");
        botMsg.classList.add("message", "bot-message");

        // دعم Markdown
        let answerText = data.answer || "لا يوجد رد من AI";
        botMsg.innerHTML = marked.parse(answerText);

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
