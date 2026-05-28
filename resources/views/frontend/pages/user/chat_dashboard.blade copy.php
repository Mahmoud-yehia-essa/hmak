@extends('frontend.pages.user.user_dashboard')

@section('user_content')

@php
    // لاستخدام روابط قابلة للنقر إذا تم جلبها من الخادم (backup)
    function makeLinks($text) {
        return preg_replace(
            '/(https?:\/\/[^\s]+)/',
            '<a href="$1" target="_blank" style="color:blue;">$1</a>',
            e($text)
        );
    }
@endphp

<!-- CSRF token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="col-lg-9">

    {{-- Chat Section --}}
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">التعليقات على الخدمة المطلوبة</h5>
        </div>

        <div id="chatBox" class="card-body" style="height: 400px; overflow-y: auto; background: #f9f9f9;">
            {{-- Messages will load here via AJAX --}}
        </div>

        {{-- Message Input --}}
        <div class="card-footer bg-white border-top">
            <form id="chatForm" class="d-flex">
                <input type="hidden" name="service_id" id="service_id" value="{{ $service->id }}" />
                <input type="text" name="comment" id="comment" class="form-control me-2" placeholder="اكتب رسالتك هنا...">
                <button type="submit" class="btn btn-primary">إرسال</button>
            </form>
            <div id="error-msg" class="text-danger mt-1"></div>
        </div>
    </div>

    {{-- Order Info --}}
    <div class="card shadow mt-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">معلومات الطلب</h5>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6 mb-2">
                    <div class="p-3 border rounded bg-light">
                        <strong>اسم الخدمة:</strong>
                        <span>{{ $service->service->title ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="p-3 border rounded bg-light">
                        <strong>حالة الطلب:</strong>
                        @if($service->status == 'completed')
                            <span class="badge bg-success text-white">مكتمل</span>
                        @elseif($service->status == 'approved')
                            <span class="badge bg-info text-white">الموافقة على العمل وتحديد السعر</span>
                        @elseif($service->status == 'working')
                            <span class="badge bg-warning text-dark">تأكيد العمل وجاري العمل عليه</span>
                        @elseif($service->status == 'pending')
                            <span class="badge bg-secondary text-white">قيد الانتظار</span>
                        @else
                            <span class="badge bg-danger text-white">مرفوض</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="p-3 border rounded bg-light">
                        <strong>تاريخ الطلب:</strong>
                        <span>{{ $service->created_at->format('d/m/Y H:i') ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="p-3 border rounded bg-light">
                        <strong>آخر تعديل على الطلب:</strong>
                        <span>{{ $service->updated_at->diffForHumans() ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    var chatBox = $('#chatBox');

    // Scroll chat to bottom
    function scrollChatToBottom() {
        chatBox.scrollTop(chatBox[0].scrollHeight);
    }

    // Convert URLs to clickable links
    function makeLinks(text) {
        if(!text) return '';
        var urlPattern = /(https?:\/\/[^\s]+)/g;
        return text.replace(urlPattern, function(url) {
            return `<a href="${url}" target="_blank" style="color:blue;">${url}</a>`;
        });
    }

    // Render a single message
    function renderMessage(msg) {
        if(!msg || !msg.user) return '';

        var userInitial = msg.user.fname.charAt(0);
        var userName = msg.user.fname;
        var time = new Date(msg.created_at).toLocaleTimeString();
        var comment = makeLinks(msg.comment ?? '');

        var isCurrentUser = msg.user_id === {{ Auth::id() }};
        var html = '';

        if(isCurrentUser){
            html += `<div class="d-flex mb-4">
                        <div class="me-3">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                                 style="width:45px; height:45px; font-size:18px;">
                                ${userInitial}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="p-3 rounded shadow-sm bg-white">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong>${userName}</strong>
                                    <small class="text-muted">${time}</small>
                                </div>
                                <p class="mb-0">${comment}</p>
                            </div>
                        </div>
                    </div>`;
        } else {
            html += `<div class="d-flex mb-4">
                        <div class="me-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                 style="width:45px; height:45px; font-size:18px;">
                                ${userInitial}
                            </div>
                            <small class="text-muted">الادارة</small>
                        </div>
                        <div class="flex-grow-1">
                            <div class="p-3 rounded shadow-sm bg-white">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong>${userName}</strong>
                                    <small class="text-muted">${time}</small>
                                </div>
                                <p class="mb-0">${comment}</p>
                            </div>
                        </div>
                    </div>`;
        }

        return html;
    }

    // Fetch messages
    function fetchMessages() {
        var service_id = $('#service_id').val();
        $.get("/user/messages/fetch/" + service_id, function(data) {
            chatBox.html('');
            data.reverse().forEach(function(msg){
                chatBox.append(renderMessage(msg));
            });
            scrollChatToBottom();
        });
    }

    // Initial fetch
    fetchMessages();

    // Fetch every 2 seconds
    setInterval(fetchMessages, 2000);

    // Send message via AJAX
    $('#chatForm').submit(function(e) {
        e.preventDefault();
        var comment = $('#comment').val();
        var service_id = $('#service_id').val();
        if(comment.trim() === '') return;

        $.ajax({
            url: "{{ route('add.user.messages.ajax') }}",
            method: "POST",
            data: {
                comment: comment,
                service_id: service_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                chatBox.append(renderMessage(data));
                $('#comment').val('');
                $('#error-msg').text('');
                scrollChatToBottom();
            },
            error: function(xhr) {
                if(xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.comment){
                    $('#error-msg').text(xhr.responseJSON.errors.comment[0]);
                }
            }
        });
    });
});
</script> --}}


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    var chatBox = $('#chatBox');
    var lastMessageId = 0; // last message displayed

    function makeLinks(text) {
        if(!text) return '';
        return text.replace(/(https?:\/\/[^\s]+)/g, function(url) {
            return `<a href="${url}" target="_blank" style="color:blue;">${url}</a>`;
        });
    }

    function renderMessage(msg) {
        if(!msg || !msg.user) return '';
        var userInitial = msg.user.fname.charAt(0);
        var userName = msg.user.fname;
        var time = new Date(msg.created_at).toLocaleTimeString();
        var comment = makeLinks(msg.comment ?? '');
        var isCurrentUser = msg.user_id === {{ Auth::id() }};
        var html = '';

        if(isCurrentUser){
            html += `<div class="d-flex mb-4">
                        <div class="me-3">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                                 style="width:45px; height:45px; font-size:18px;">
                                ${userInitial}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="p-3 rounded shadow-sm bg-white">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong>${userName}</strong>
                                    <small class="text-muted">${time}</small>
                                </div>
                                <p class="mb-0">${comment}</p>
                            </div>
                        </div>
                    </div>`;
        } else {
            html += `<div class="d-flex mb-4">
                        <div class="me-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                 style="width:45px; height:45px; font-size:18px;">
                                ${userInitial}
                            </div>
                            <small class="text-muted">الادارة</small>
                        </div>
                        <div class="flex-grow-1">
                            <div class="p-3 rounded shadow-sm bg-white">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong>${userName}</strong>
                                    <small class="text-muted">${time}</small>
                                </div>
                                <p class="mb-0">${comment}</p>
                            </div>
                        </div>
                    </div>`;
        }

        return html;
    }

    function scrollChatToBottom() {
        var atBottom = chatBox.scrollTop() + chatBox.innerHeight() >= chatBox[0].scrollHeight - 50;
        if(atBottom) chatBox.scrollTop(chatBox[0].scrollHeight);
    }

    // **Fetch all messages initially**
    function loadInitialMessages() {
        var service_id = $('#service_id').val();
        $.get("/user/messages/fetch/" + service_id, function(data) {
            data.forEach(function(msg){
                chatBox.append(renderMessage(msg));
                lastMessageId = msg.id; // update lastMessageId to last message
            });
            scrollChatToBottom();
        });
    }

    loadInitialMessages(); // call on page load

    // Fetch new messages every 2 seconds
    function fetchNewMessages() {
        var service_id = $('#service_id').val();
        $.get("/user/messages/fetch/" + service_id, function(data) {
            data.forEach(function(msg){
                if(msg.id > lastMessageId){ // append only new messages
                    chatBox.append(renderMessage(msg));
                    lastMessageId = msg.id;
                }
            });
            scrollChatToBottom();
        });
    }

    setInterval(fetchNewMessages, 2000);

    // Send message
    $('#chatForm').submit(function(e) {
        e.preventDefault();
        var comment = $('#comment').val();
        var service_id = $('#service_id').val();
        if(comment.trim() === '') return;

        $.ajax({
            url: "{{ route('add.user.messages.ajax') }}",
            method: "POST",
            data: { comment: comment, service_id: service_id },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(data) {
                if(data.id > lastMessageId){
                    chatBox.append(renderMessage(data));
                    lastMessageId = data.id;
                    $('#comment').val('');
                    scrollChatToBottom();
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON?.errors?.comment){
                    $('#error-msg').text(xhr.responseJSON.errors.comment[0]);
                }
            }
        });
    });
});
</script>


@endsection
