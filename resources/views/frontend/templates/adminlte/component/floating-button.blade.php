{{--mfb-component--tl--}}
{{--mfb-component--tr--}}
{{--mfb-component--br--}}
{{--mfb-component--bl--}}

{{--mfb-slidein--}}
{{--mfb-zoomin--}}
{{--mfb-slidein-spring--}}
{{--mfb-fountain--}}

<ul id="menu" class="mfb-component--tr mfb-slidein" data-mfb-toggle="hover">
	<li class="mfb-component__wrap">

		<a href="javascript:void(0)" class="mfb-component__button--main">
			<i class="mfb-component__main-icon--resting ion-plus-round"></i>
			<i class="mfb-component__main-icon--active ion-close-round"></i>
		</a>

		<ul class="mfb-component__list">

			<li>
				<a href="{{url('/')}}" data-mfb-label="返回首页" class="mfb-component__button--child">
					<i class="mfb-component__child-icon fa fa-home"></i>
				</a>
			</li>

			<li>
				<a href="{{url('courses')}}" data-mfb-label="书目" class="mfb-component__button--child">
					<i class="mfb-component__child-icon fa fa-list-ul"></i>
				</a>
			</li>

		</ul>

	</li>
</ul>



{{--<script src="{{ asset('templates/themes/floating-button/mfb.js') }}"></script>--}}
{{--<script type="text/javascript">--}}
	{{--var panel = document.getElementById('panel'),--}}
		{{--menu = document.getElementById('menu'),--}}
		{{--showcode = document.getElementById('showcode'),--}}
		{{--selectFx = document.getElementById('selections-fx'),--}}
		{{--selectPos = document.getElementById('selections-pos'),--}}
		{{--// demo defaults--}}
		{{--effect = 'mfb-zoomin',--}}
		{{--pos = 'mfb-component--br';--}}

	{{--showcode.addEventListener('click', _toggleCode);--}}
	{{--selectFx.addEventListener('change', switchEffect);--}}
	{{--selectPos.addEventListener('change', switchPos);--}}

	{{--function _toggleCode() {--}}
	  {{--panel.classList.toggle('viewCode');--}}
	{{--}--}}

	{{--function switchEffect(e){--}}
	  {{--effect = this.options[this.selectedIndex].value;--}}
	  {{--renderMenu();--}}
	{{--}--}}

	{{--function switchPos(e){--}}
	  {{--pos = this.options[this.selectedIndex].value;--}}
	  {{--renderMenu();--}}
	{{--}--}}

	{{--function renderMenu() {--}}
	  {{--menu.style.display = 'none';--}}
	  {{--// ?:-)--}}
	  {{--setTimeout(function() {--}}
		{{--menu.style.display = 'block';--}}
		{{--menu.className = pos + effect;--}}
	  {{--},1);--}}
	{{--}--}}
{{--</script>--}}

