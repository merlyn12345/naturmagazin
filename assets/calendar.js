$(document).ready(function() {

	// initial load the calendar base on the requestedEventDateForCalendar from the calendar.template (e.g. a date or null)
	reloadCalendar(requestedEventDateForCalendar, function() {
		setMonthArrowEvents();
	})
	
	function setMonthArrowEvents() {
		$('.month-arrow').click(function(event) {
			event.preventDefault();
			var anchor = $(this);
			anchor.unbind('click');
			reloadCalendar(anchor.attr('data-month'), function(data) {
				setMonthArrowEvents();
			})
		})
	}

	/**
	 *
	 * @param day
	 * @param callback
	 */
	function reloadCalendar(day, callback) {

		var uri = baseUri + 'ajax/!/action/getCalendar';
		if(day != null) {
			uri += '/day/' + day
		}
		
		$('#calendar-container').html('').addClass('spin');
		$.get(uri, function(data) {
			$('#calendar-container').removeClass('spin').html(data);

			if(typeof(requestedEventDate) !== 'undefined') {
				// check if we have a requestedDate set (requestedEventDate is set in the event template)
				$('a.event[data-date="' + requestedEventDate +'"]').addClass('current');
			}

			callback();
		})
	}
})