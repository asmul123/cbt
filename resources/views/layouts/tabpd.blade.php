<div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
    <a class="list-group-item list-group-item-action {{($tab=='penugasan' ? 'active' : false)}}" id="list-sunday-list"
     href="{{ url('/pembelajaranpd/'.$pembelajaran->id) }}" role="tab">Penugasan</a>
    <a class="list-group-item list-group-item-action {{($tab=='diskusi' ? 'active' : false)}}" id="list-monday-list"
        href="{{ url('/pembelajarapdn/'.$pembelajaran->id."?tab=diskusi") }}" role="tab">Diskusi Kelas</a>
    <a class="list-group-item list-group-item-action {{($tab=='kehadiran' ? 'active' : false)}}" id="list-tuesday-list"
        href="{{ url('/pembelajaranpd/'.$pembelajaran->id."?tab=kehadiran") }}" role="tab">Kehadiran</a>
</div>