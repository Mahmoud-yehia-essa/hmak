@extends('frontend.pages.user.user_dashboard')
@section('user_content')

@php
// Helper function to detect links inside messages
function makeLinksClickable($text) {
    $pattern = '/((https?:\/\/|www\.)[^\s]+)/i';
    return preg_replace_callback($pattern, function ($matches) {
        $url = $matches[0];
        $href = strpos($url, 'http') === 0 ? $url : "http://$url";
        return '<a href="' . $href . '" target="_blank" class="text-decoration-underline text-primary">' . $url . '</a>';
    }, e($text));
}
@endphp

<div class="col-lg-9">
    <div class="card p-4 shadow">
        <h3 class="mb-4">مرحبًا, {{ Auth::user()->fname }}</h3>

        <!-- Check if user has services -->
        @if($getUserService->isNotEmpty())
            <div class="table-responsive mt-4">
                <table class="table table-bordered text-end" style="direction: rtl;">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">الرقم</th>
                            <th scope="col">الخدمة</th>
                            <th scope="col">الحالة</th>
                            <th scope="col">التاريخ</th>
                            <th scope="col">سعر الخدمة</th>

                            <th scope="col">المزيد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($getUserService as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->service->title }}</td>
                              <td>
    @if($item->status == 'completed')
        <span class="badge bg-success text-white">مكتمل</span>
    @elseif($item->status == 'approved')
        <span class="badge bg-info text-white">الموافقة على العمل وتحديد السعر</span>
    @elseif($item->status == 'working')
        <span class="badge bg-warning text-dark">تأكيد العمل وجاري العمل عليه</span>
    @elseif($item->status == 'pending')
        <span class="badge bg-secondary text-white">قيد الانتظار</span>
    @else
        <span class="badge bg-danger text-white">مرفوض</span>
    @endif
</td>
                                <td>{{ $item->created_at->diffForHumans() }}</td>

                                <td>{{ $item->total_price ?? "غير محدد بعد"}}</td>

                                <td>
                                    <!-- Details button -->
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#serviceModal{{ $item->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Chat icon button -->
                                    {{-- <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#chatModal{{ $item->id }}">
                                        <i class="bi bi-chat-dots"></i>
                                    </button> --}}



                                    <a href="{{route('show.user.messages',$item->id)}}" type="button" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-chat-dots"></i>
                                    </a>


                                </td>
                            </tr>

                            <!-- Chat Modal -->
                            <div class="modal fade" id="chatModal{{ $item->id }}" tabindex="-1" aria-labelledby="chatModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="chatModalLabel{{ $item->id }}">المحادثة حول: {{ $item->service->title }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body" style="height: 400px; overflow-y: auto; background: #f9f9f9;">

                                            {{-- Example admin message --}}
                                            <div class="d-flex mb-3">
                                                <div class="p-3 rounded bg-light border" style="max-width: 70%;">
                                                    <div class="small text-muted mb-1">المدير • منذ 5 دقائق</div>
                                                    <div>{!! makeLinksClickable('مرحبا بك! سنتابع طلبك هنا: www.example.com') !!}</div>
                                                </div>
                                            </div>

                                            {{-- Example user message --}}
                                            <div class="d-flex justify-content-end mb-3">
                                                <div class="p-3 rounded bg-success text-white" style="max-width: 70%;">
                                                    <div class="small text-white-50 mb-1">{{ Auth::user()->fname }} • منذ 2 دقائق</div>
                                                    <div>{!! makeLinksClickable('شكرًا لكم') !!}</div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer bg-light">
                                            <form class="d-flex w-100">
                                                <input type="text" class="form-control me-2" placeholder="اكتب رسالتك هنا...">
                                                <button type="submit" class="btn btn-primary">إرسال</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Details Modal -->
                            <div class="modal fade" id="serviceModal{{ $item->id }}" tabindex="-1" aria-labelledby="serviceModal{{ $item->id }}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-end" style="direction: rtl;">
                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title fw-bold" id="serviceModal{{ $item->id }}Label">تفاصيل الخدمة</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="p-3 border rounded mb-2">
                                                <span class="fw-bold">الخدمة:</span>
                                                <span>{{ $item->service->title }}</span>
                                            </div>

                                             <div class="p-3 border rounded mb-2">
                                                <span class="fw-bold">التكلفة:</span>
                                                <span>{{ $item->total_price ?? "غير محدد بعد" }}</span>
                                            </div>
                                            <div class="p-3 border rounded mb-2">
                                                <span class="fw-bold">الوصف:</span>
                                                <span>{{ $item->des }}</span>
                                            </div>
                                            <div class="p-3 border rounded mb-2">
                                                <span class="fw-bold">الحالة:</span>
                                              @if($item->status == 'completed')
        <span class="badge bg-success text-white">مكتمل</span>
    @elseif($item->status == 'approved')
        <span class="badge bg-info text-white">الموافقة على العمل وتحديد السعر</span>
    @elseif($item->status == 'working')
        <span class="badge bg-warning text-dark">تأكيد العمل وجاري العمل عليه</span>
    @elseif($item->status == 'pending')
        <span class="badge bg-secondary text-white">قيد الانتظار</span>
    @else
        <span class="badge bg-danger text-white">مرفوض</span>
    @endif
                                            </div>
                                            <div class="p-3 border rounded mb-2">
                                                <span class="fw-bold">تاريخ الإنشاء:</span>
                                                <span>{{ $item->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="p-3 border rounded">
                                                <span class="fw-bold">تاريخ آخر تعديل على الطلب:</span>
                                                <span>{{ $item->updated_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Show this message if no services exist -->
            <div class="text-center text-muted py-5">
                <i class="bi bi-info-circle fs-1 mb-3"></i>
                <p class="mb-0 fs-5">لا توجد طلبات حالياً</p>
            </div>
        @endif

    </div>
</div>

@endsection
