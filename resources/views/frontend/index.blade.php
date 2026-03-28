@include('frontend.head')
@include('frontend.header')

<main>
    <section class="mt-5 sSm" style="margin-top: 120px!important;">

        <div id="carouselExampleControls" class="carousel slide mt-5" data-bs-ride="carousel">
            <div class="carousel-inner pt-md-5 pt-3">
                <div class="carousel-item ">
                    <img loading="lazy" src="{{ asset('front/uploads/1812324939.') }}"
                        class="d-block w-100 d-block d-md-none" height="200" alt="...">
                    <img loading="lazy" src="{{ asset('front/uploads/1812324939.') }}"
                        class="d-block w-100 d-none d-md-block" height="400" alt="...">

                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <!-- /carousel -->
    <section class="container mt-4 mb-3 sSm" style="margin-top: 5rem;">


        @include('frontend.slider')
        @include('frontend.main_categories')
        @include('frontend.sub_categories')



        <!-- /card 1 -->
        <a href="https://wa.me/+123" class="contact p-1 rounded-circle text-center"
            style="background-color:#4dc247;width:50px;height:50px;">
            <i class="fab fa-whatsapp text-white my-1 fa-2x"></i>
        </a>


</main>
@if (!session()->has('country_id'))

<div class="modal fade" id="countryModal" tabindex="-1"
     data-bs-backdrop="static"
     data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">

            <h4 class="mb-3">🌍 اختر دولتك</h4>
            <p class="text-muted">اختر الدولة لعرض المنتجات المناسبة لك</p>

            <select id="countrySelect" class="form-control mb-3">
                <option value="">-- اختر الدولة --</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-primary w-100" onclick="saveCountry()">
                تأكيد
            </button>

        </div>
    </div>
</div>

@endif
@include('frontend.reviews')
@include('frontend.footer')
<script>
document.addEventListener("DOMContentLoaded", function () {

    @if (!session()->has('country_id'))
        let modalEl = document.getElementById('countryModal');

        let modal = new bootstrap.Modal(modalEl, {
            backdrop: 'static',
            keyboard: false
        });

        modal.show();

        // 🔥 يمنع الإغلاق نهائياً
        modalEl.addEventListener('hide.bs.modal', function (event) {
            event.preventDefault();
        });
    @endif

});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    @if (!session()->has('country_id'))
        let modal = new bootstrap.Modal(document.getElementById('countryModal'));
        modal.show();
    @endif
});

function saveCountry() {
    let countryId = document.getElementById('countrySelect').value;

    if (!countryId) {
        alert('اختر دولة أولاً');
        return;
    }

    fetch("{{ route('set.country') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            country_id: countryId
        })
    })
    .then(res => res.json())
    .then(data => {
        location.reload(); // إعادة تحميل الصفحة
    });
}
</script>