$('button[name=btn1]').click(function () {
	$.notify("Hello World");
});

$('button[name=btn2]').click(function () {
	$.notify({
		title: "Welcome:",
		message: "This plugin has been provided to you by Robert McIntosh aka mouse0270"
	});
});

$('button[name=btn3]').click(function () {
	$.notify({
		title: "&lt;strong>Welcome:&lt;/strong> ",
		message: "This plugin has been provided to you by Robert McIntosh aka mouse0270"
	});
});

$('button[name=btn4]').click(function () {
	$.notify({
		title: "&lt;strong>Welcome:&lt;/strong> ",
		message: "This plugin has been provided to you by Robert McIntosh aka &lt;a href=\"https://twitter.com/Mouse0270\" target=\"_blank\">@mouse0270&lt;/a>"
	});
});
$('button[name=btn5]').click(function () {
	$.notify({
		icon: 'glyphicon glyphicon-star',
		message: "Everyone loves font icons! Use them in your notification!"
	});
});
$('button[name=btn6]').click(function () {
	$.notify({
		icon: 'fa fa-paw',
		message: "You're not limited to just Bootstrap Font Icons"
	});
});
$('button[name=btn7]').click(function () {
	$.notify({
		icon: "img/growl_64x.png",
		message: " I am using an image."
	},{
		icon_type: 'image'
	});
});
$('button[name=btn8]').click(function () {
	$.notify({
		message: "Check out my twitter account by clicking on this notification!",
		url: "https://twitter.com/Mouse0270"
	});
});
$('button[name=btn9]').click(function () {
	$.notify({
		message: "Check out my twitter account by clicking on this notification!",
		url: "https://twitter.com/Mouse0270",
		target: "_self"
	});
});
$('button[name=btn10]').click(function () {
	$.notify({
		message: "Check out my twitter account by clicking on this notification!",
		url: "https://twitter.com/Mouse0270"
	},{
		url_target: "_self"
	});
});
$('button[name=btn11]').click(function () {
	$.notifyDefaults({
		url_target: "_self"
	});
	$.notify({
		message: "Check out my twitter account by clicking on this notification!",
		url: "https://twitter.com/Mouse0270"
	});
});
$('button[name=btn12]').click(function () {
	$.notifyDefaults({
		url_target: "_self"
	});
	$.notify({
		message: "Check out my twitter account by clicking on this notification!",
		url: "https://twitter.com/Mouse0270",
		target: "_blank"
	});
});
$('button[name=btn13]').click(function () {
	$.notify('Hello World', {
		offset: 50
	});
});
$('button[name=btn14]').click(function () {
	$.notify('Hello World', {
		offset: {
			x: 50,
			y: 50
		}
	});
});
$('button[name=btn15]').click(function () {
	$.notify({
		icon: 'https://randomuser.me/api/portraits/med/men/77.jpg',
		title: 'Byron Morgan',
		message: 'Momentum reduce child mortality effectiveness incubation empowerment connect.'
	},{
		type: 'minimalist',
		delay: 5000,
		icon_type: 'image',
		template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
			'<img data-notify="icon" class="img-circle pull-left">' +
			'<span data-notify="title">{1}</span>' +
			'<span data-notify="message">{2}</span>' +
		'</div>'
	});
});
$('button[name=btn16]').click(function () {
	$.notify({
		title: 'Email: Erica Fisher',
		message: 'Investment, stakeholders micro-finance equity health Bloomberg; global citizens climate change. Solve positive social change sanitation, opportunity insurmountable challenges...'
	},{
		type: 'pastel-warning',
		delay: 5000,
		template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
			'<span data-notify="title">{1}</span>' +
			'<span data-notify="message">{2}</span>' +
		'</div>'
	});
});

$('button[name=btnpos]').click(function () {
	$.notify('I will not close until my delay is up.', {
		allow_dismiss: false,
		placement: {
			from: 'bottom',
			align: 'right'
		}
	});
});