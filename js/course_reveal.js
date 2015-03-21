$('.course_detail').hide();
$('.revealer').click(function(){
	$this_course = $(this).next('.course_detail');
	if ($this_course.is(':hidden')) {
		$this_course.slideDown("slow");
		$this_course.css({
			"border-bottom": "1px solid red",
			"padding": "10px",
			"margin-bottom": "10px"
		});
	} else {
		$this_course.slideUp("fast");
	}
});
