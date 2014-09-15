(function($) {
$(window).load(function() {
	
	//claculate proper width
	function cis_calculate_width() {
		$('.cis_images_holder').each(function() {
			var $wrapper = $(this);
			var total_w = 0;
			$wrapper.find('.cis_row_item').each(function() {
				$(this).find('img').css('width','auto');
				var w = parseInt($(this).find('img').width());
				$(this).find('img').width(w);
				var m_r = isNaN(parseFloat($(this).css('margin-right'))) ? 0 : parseFloat($(this).css('margin-right'));
				var m_l = isNaN(parseFloat($(this).css('margin-left'))) ? 0 : parseFloat($(this).css('margin-left'));
				total_w += w + m_r*1 + m_l*1;
			});
			total_w = total_w + 1*1;
			$wrapper.width(total_w);
		});
	};
	
	setTimeout(function() {
		cis_calculate_width();
	},400);	

	//resize
	$(window).resize(function() {
	  cis_calculate_width();
	});
	
	$(".cis_row_item img").each(function() {
		var $cis_overlay = $(this).next('.cis_row_item_overlay');
		if($cis_overlay.attr('cis_animation') == 'enabled')
			return;
		$cis_overlay.css({'visibility' : 'hidden','display' : 'block'});
		var h = $cis_overlay.height();
		$cis_overlay.css({'visibility' : 'visible','display' : 'block','height' : '0'}).attr('h',h);
		$cis_overlay.attr('cis_animation','enabled');
	});
	
	$(".cis_row_item img").each(function() {
		if($(this).attr('cis_loaded') == 'loaded')
			return;
		cis_make_pr($(this));
	});
	
	function cis_make_pr($el) {
		if($el.attr('cis_loaded') == 'loaded')
			return;
		var item_width = $el.width();
		$el.parents('.cis_row_item').find('.cis_row_item_loader').animate({
			width: item_width
		},400,'swing',function() {
			$el.parents('.cis_row_item').find('.cis_row_item_loader').fadeOut(200,function() {
				$el.parents('.cis_row_item_inner').hide().removeClass('cis_row_hidden_element').fadeIn(200);
			});
		});
	};
	
});

$(document).ready(function() {
	//creative popup///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/*
	//make items ordering
	*/
	function cis_make_creative_items_orders() {
		$('.cis_main_wrapper').each(function(){
			var curr_order = 0;
			$(this).find('.cis_row_item').each(function() {
				$(this).attr("cis_item_order",curr_order)
				curr_order ++;
			})
		})
	};
	cis_make_creative_items_orders();


	//slider correction////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$('.cis_row_item').mouseenter(function() {
		cis_make_slider_item_correction($(this));
	});

	function cis_make_slider_item_correction($elem) {
		var $loader = $elem.find('.cis_row_item_loader'); 
		var slider_id = $loader.parents('.cis_main_wrapper').attr("cis_slider_id");
		var item_id = $loader.parents('.cis_row_item').attr("item_id");

		//check if slider in scroll progress, then return
		if($loader.parents('.cis_main_wrapper').find('.cis_images_holder').hasClass('cis_scrolling'))
			return;

		var $cis_popup = $('.cis_popup_wrapper');

		var loader_width = parseInt($loader.css('width'));
		var items_m_r = parseInt($loader.parents('.cis_row_item').css('margin-right'));

		//get slider_offset
		var image_index = $loader.parents('.cis_row_item').attr("cis_item_order");
		var total_items_width = 0;
		$loader.parents('.cis_main_wrapper').find('.cis_row_item').each(function(i) {
			var w = parseInt($(this).width());
			var m_r = parseInt($(this).css('margin-right'));
			total_items_width = total_items_width + 1*w + 1*m_r;
			if(i == image_index)
				return false;
		});

		var current_left_offset = Math.abs(parseInt($loader.parents('.cis_main_wrapper').find('.cis_images_holder').css('margin-left')));
		var wrapper_width = parseInt($loader.parents('.cis_main_wrapper').width());

		var offset1 = total_items_width - current_left_offset;
		var direction = 0;
		var item_offset_to_move = 0;
		if(offset1 >= wrapper_width) {
			var item_offset = total_items_width - current_left_offset - wrapper_width - items_m_r;
			var item_offset_to_move = item_offset < 0 ? 0 : item_offset;
		}
		else {
			if(offset1 < loader_width) {
				var item_offset_to_move = loader_width - offset1 + 1*items_m_r;
				direction = 1;
			}
		};

		var popup_loader_animate_timeout = 400;
		if(item_offset_to_move > 0) {
			// popup_loader_animate_timeout = Math.abs(item_offset_to_move) * 4;
			if(direction == 1) {
				$loader.parents('.cis_main_wrapper').find('.cis_images_holder').stop().animate({
					'margin-left': "+=" + item_offset_to_move
				},popup_loader_animate_timeout,'swing');
			}
			else {
				$loader.parents('.cis_main_wrapper').find('.cis_images_holder').stop().animate({
					'margin-left': "-=" + item_offset_to_move
				},popup_loader_animate_timeout,'swing');
			};
		};
	};

	// slider autoplay///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	var cis_evenly_move_intervals = new Array();
	var cis_autoplay_start_timeouts = new Array();
	var cis_autoplay_animate_back_timeouts = new Array();
	function cis_make_autoplay() {
		$(".cis_main_wrapper").each(function() {
			$wrapper = $(this);
			//get autoplay data
			var slider_data = $wrapper.find('.cis_moving_data').html();
			var slider_data_array = slider_data.split(',');
			var slider_autoplay = parseInt(slider_data_array[3]);
			var slider_autoplay_start_timeout = parseInt(slider_data_array[4]); 
			var slider_autoplay_step_timeout = parseInt(slider_data_array[5]);
			var slider_autoplay_evenly_speed = parseInt(slider_data_array[6]);
			
			if(slider_autoplay == 0) {
				return;
			}
			else if(slider_autoplay == 1) {
				cis_make_evenly_autoplay($wrapper);
			}
			else if(slider_autoplay == 2) {
				cis_make_steps_autoplay($wrapper);
			}
		});
	};
	cis_make_autoplay();
	
	function cis_make_steps_autoplay($wrapper) {
		var slider_id = $wrapper.attr("roll");
		
		var slider_data = $wrapper.find('.cis_moving_data').html();
		var slider_data_array = slider_data.split(',');
		var slider_autoplay_start_timeout = parseInt(slider_data_array[4]);
		var slider_autoplay_step_timeout = parseInt(slider_data_array[5]);
		var slider_autoplay_restart_timeout = parseInt(slider_data_array[7]);
		
		cis_autoplay_animate_back_timeouts[slider_id] = '';
		
		cis_autoplay_start_timeouts[slider_id] = setTimeout(function() {//set timeout
			//set interval
			cis_evenly_move_intervals[slider_id] = setInterval(function() {
				cis_move_slider_by_steps($wrapper);
			},slider_autoplay_step_timeout);
		},slider_autoplay_start_timeout);
		
		$wrapper.hover(function() {
			clearTimeout(cis_autoplay_start_timeouts[slider_id]);
			clearTimeout(cis_autoplay_animate_back_timeouts[slider_id]);
			clearInterval(cis_evenly_move_intervals[slider_id]);
			$wrapper.addClass('cis_mouseentered');
		},function() {
			//check if popup vissible///////////////////////////////////
			var $cis_popup = $('.cis_popup_wrapper');
			var popup_slider_id = $cis_popup.attr("slider_id");
			if($cis_popup.hasClass('cis_vissible') && popup_slider_id == slider_id) {
				return;
			}

			cis_autoplay_start_timeouts[slider_id] = setTimeout(function() {//set timeout
				//set interval
				cis_evenly_move_intervals[slider_id] = setInterval(function() {
					cis_move_slider_by_steps($wrapper);
				},slider_autoplay_step_timeout);
			},slider_autoplay_restart_timeout);
			$wrapper.removeClass('cis_mouseentered');
		});
	};
	
	function cis_move_slider_by_steps($wrapper) {
		var slider_id = $wrapper.attr("roll");
		
		var slider_data = $wrapper.find('.cis_moving_data').html();
		var slider_data_array = slider_data.split(',');
		var slider_autoplay_start_timeout = parseInt(slider_data_array[4]);
		var slider_autoplay_step_timeout = parseInt(slider_data_array[5]);
		
		$cis_images_holder = $wrapper.find('.cis_images_holder');
		var screen_w = parseFloat($cis_images_holder.parent('div').width());
		var total_w = parseFloat($cis_images_holder.width());
		
		if(total_w >= screen_w)
			var result = cis_move_images_holder_left($cis_images_holder);
		else
			var result = cis_move_images_holder_right($cis_images_holder);
		
		if(result == 'end') {
			clearTimeout(cis_autoplay_start_timeouts[slider_id]);
			clearInterval(cis_evenly_move_intervals[slider_id]);
			
			var cis_animate_back_to_start_timeout = slider_autoplay_step_timeout;
			var cis_animate_back_to_start_time = Math.abs(parseInt((total_w - screen_w) * 1.5));
			cis_animate_back_to_start_time = cis_animate_back_to_start_time < 600 ? 600 : cis_animate_back_to_start_time;

			var $sl = $('.cis_wrapper_' + slider_id).find('.cis_images_holder');;
			//set timeout to animate back
			cis_autoplay_animate_back_timeouts[slider_id] = setTimeout(function() {
				//animate back to start
				$sl.stop(true,false).animate({
					'margin-left': 0
				},cis_animate_back_to_start_time,'easeOutBack', function() {
					//check to see that mouseenter does not happened
					if($wrapper.hasClass('cis_mouseentered'))
						return;
					
					var $sl = $('.cis_wrapper_' + slider_id);
					//set new autoplay
					cis_autoplay_start_timeouts[slider_id] = setTimeout(function() {//set timeout
						//set interval
						cis_evenly_move_intervals[slider_id] = setInterval(function() {
							cis_move_slider_by_steps($sl);
						},slider_autoplay_step_timeout);
					},slider_autoplay_start_timeout);
				});
			},cis_animate_back_to_start_timeout);
				
		}
	};
	
	var cis_interval_time = 250;
	
	function cis_make_evenly_autoplay($wrapper) {
		var slider_id = $wrapper.attr("roll");
		
		var slider_data = $wrapper.find('.cis_moving_data').html();
		var slider_data_array = slider_data.split(',');
		var slider_autoplay_start_timeout = parseInt(slider_data_array[4]);
		var slider_autoplay_restart_timeout = parseInt(slider_data_array[7]);
		
		cis_autoplay_animate_back_timeouts[slider_id] = '';
		
		cis_autoplay_start_timeouts[slider_id] = setTimeout(function() {//set timeout
			//set interval
			cis_evenly_move_intervals[slider_id] = setInterval(function() {
				cis_move_slider_evenly($wrapper);
			},cis_interval_time);
		},slider_autoplay_start_timeout);
		
		$wrapper.hover(function() {
			clearTimeout(cis_autoplay_start_timeouts[slider_id]);
			clearTimeout(cis_autoplay_animate_back_timeouts[slider_id]);
			clearInterval(cis_evenly_move_intervals[slider_id]);
			$wrapper.addClass('cis_mouseentered');
		},function() {
			//check if popup vissible///////////////////////////////////
			var $cis_popup = $('.cis_popup_wrapper');
			var popup_slider_id = $cis_popup.attr("slider_id");
			if($cis_popup.hasClass('cis_vissible') && popup_slider_id == slider_id) {
				return;
			}

			cis_autoplay_start_timeouts[slider_id] = setTimeout(function() {//set timeout
				//set interval
				cis_evenly_move_intervals[slider_id] = setInterval(function() {
					cis_move_slider_evenly($wrapper);
				},cis_interval_time);
			},slider_autoplay_restart_timeout);
			$wrapper.removeClass('cis_mouseentered');
		});
	};
	
	function cis_move_slider_evenly($wrapper) {
		var slider_id = $wrapper.attr("roll");
		
		//get autoplay data
		var slider_data = $wrapper.find('.cis_moving_data').html();
		var slider_data_array = slider_data.split(',');
		var slider_autoplay_start_timeout = parseInt(slider_data_array[4]);
		var slider_autoplay_evenly_speed = parseInt(slider_data_array[6]);
		
		$cis_images_holder = $wrapper.find('.cis_images_holder');
		var screen_w = parseFloat($cis_images_holder.parent('div').width());
		var total_w = parseFloat($cis_images_holder.width());
		var curr_left = parseFloat($cis_images_holder.css('margin-left'));
		curr_left = (total_w >= screen_w) ? curr_left - slider_autoplay_evenly_speed : curr_left + 1 * slider_autoplay_evenly_speed;
		
		var cis_single_autoplay_time = 400;
		var cis_autoplay_ease_time = 600;
		var cis_animate_back_to_start_timeout = 2000;
		var cis_animate_back_to_start_time = Math.abs(parseInt((total_w - screen_w) * 1.5));
		cis_animate_back_to_start_time = cis_animate_back_to_start_time < 600 ? 600 : cis_animate_back_to_start_time;
		
		var slider_data = $wrapper.find('.cis_moving_data').html();
		var slider_data_array = slider_data.split(',');
		var delta_offset = parseInt(slider_data_array[0]);
		var move_speed_time = parseInt(slider_data_array[1]); 
		var ease_effect = parseInt(slider_data_array[2]);
		var effect_type = 'swing';
		
		ease_effect = slider_autoplay_evenly_speed;
		
		if(total_w >= screen_w) {
			//check if end
			if(Math.abs(curr_left) + 1 * screen_w >= total_w) {
				clearTimeout(cis_autoplay_start_timeouts[slider_id]);
				clearInterval(cis_evenly_move_intervals[slider_id]);
				
				var desired_left = screen_w - total_w;
				var desired_left_1 = desired_left;
				desired_left_1 = (total_w < screen_w) ? desired_left_1 + ease_effect * 1 : desired_left_1 - ease_effect * 1; 
				
				//calculate last point speed
				var curr_left_final = parseFloat($cis_images_holder.css('margin-left'));
				var move_speed_time_final = Math.abs(curr_left_final - desired_left_1) * cis_single_autoplay_time  / slider_autoplay_evenly_speed;
				$cis_images_holder.stop(true,false).animate({//swing effect
					'margin-left': desired_left_1
				},move_speed_time_final,effect_type,function() {
					//easing animation on end
					var $sl = $('.cis_wrapper_' + slider_id).find('.cis_images_holder');
					$sl.stop().animate({
						'margin-left': desired_left
					},cis_autoplay_ease_time,'easeOutBack', function() {
						
						//check to see that mouseenter does not happened
						if($wrapper.hasClass('cis_mouseentered'))
							return;
						
						var $sl = $('.cis_wrapper_' + slider_id).find('.cis_images_holder');
						//set timeout to animate back
						cis_autoplay_animate_back_timeouts[slider_id] = setTimeout(function() {
							//animate back to start
							$sl.stop(true,false).animate({
								'margin-left': 0
							},cis_animate_back_to_start_time,'easeOutBack', function() {
								//check to see that mouseenter does not happened
								if($wrapper.hasClass('cis_mouseentered'))
									return;
								
								var $sl = $('.cis_wrapper_' + slider_id);
								//set new autoplay
								cis_autoplay_start_timeouts[slider_id] = setTimeout(function() {//set timeout
									//set interval
									cis_evenly_move_intervals[slider_id] = setInterval(function() {
										cis_move_slider_evenly($sl);
									},cis_interval_time);
								},slider_autoplay_start_timeout);
							});
						},cis_animate_back_to_start_timeout);
					});
				});
			}
			else {
				$cis_images_holder.stop(true,false).animate({
					'margin-left': curr_left
				},cis_single_autoplay_time,'linear');
			}
		}
		else {
			//check if end
			if(Math.abs(curr_left) + 1 * total_w >= screen_w) {
				//clear timeouts, intervals
				clearTimeout(cis_autoplay_start_timeouts[slider_id]);
				clearInterval(cis_evenly_move_intervals[slider_id]);
				
				var desired_left = screen_w - total_w;
				var desired_left_1 = desired_left;
				desired_left_1 =  desired_left_1 + ease_effect * 1;
				
				//calculate last point speed
				var curr_left_final = parseFloat($cis_images_holder.css('margin-left'));
				var move_speed_time_final = Math.abs(curr_left_final - desired_left_1) * cis_single_autoplay_time  / slider_autoplay_evenly_speed;
				$cis_images_holder.stop(true,false).animate({//swing effect
					'margin-left': desired_left_1
				},move_speed_time_final,effect_type,function() {
					//easing animation on end
					var $sl = $('.cis_wrapper_' + slider_id).find('.cis_images_holder');
					$sl.stop().animate({
						'margin-left': desired_left
					},cis_autoplay_ease_time,'easeOutBack', function() {
						//check to see that mouseenter does not happened
						if($wrapper.hasClass('cis_mouseentered'))
							return;
						var $sl = $('.cis_wrapper_' + slider_id).find('.cis_images_holder');
						//set timeout to animate back
						cis_autoplay_animate_back_timeouts[slider_id] = setTimeout(function() {
							//animate back to start
							$sl.stop(true,false).animate({
								'margin-left': 0
							},cis_animate_back_to_start_time,'easeOutBack', function() {
								//check to see that mouseenter does not happened
								if($wrapper.hasClass('cis_mouseentered'))
									return;
								
								var $sl = $('.cis_wrapper_' + slider_id);
								//set new autoplay
								cis_autoplay_start_timeouts[slider_id] = setTimeout(function() {//set timeout
									//set interval
									cis_evenly_move_intervals[slider_id] = setInterval(function() {
										cis_move_slider_evenly($sl);
									},cis_interval_time);
								},slider_autoplay_start_timeout);
							});
						},cis_animate_back_to_start_timeout);
					});
				});
			}
			else {
				$cis_images_holder.stop(true,false).animate({
					'margin-left': curr_left
				},cis_single_autoplay_time,'linear');
			}
		}
		
	};
	
	//arrows
	function cis_prepare_arrows() {
		$(".cis_main_wrapper").each(function() {
			var $wrapper = $(this);
			var $left_arrow = $wrapper.find('.cis_button_left');
			var $right_arrow = $wrapper.find('.cis_button_right');
			
			//get arrows data
			var arr_data = $wrapper.find('.cis_arrow_data').html();
			var arr_data_array = arr_data.split(',');
			var arrow_width = arr_data_array[0];
			var arrow_corner_offset = arr_data_array[1];
			var arrow_middle_offset = arr_data_array[2];
			var arrow_opacity = arr_data_array[3] / 100;
			var show_arrows = arr_data_array[4];
			
			//set data
			$left_arrow.attr("op",arrow_opacity);
			$left_arrow.attr("corner_offset",arrow_corner_offset);
			$right_arrow.attr("op",arrow_opacity);
			$right_arrow.attr("corner_offset",arrow_corner_offset);
			
			//set styles
			$left_arrow.css('width',arrow_width);
			$right_arrow.css('width',arrow_width);
			
			var arrow_height = parseInt ($left_arrow.height());
			var wrapper_height = parseFloat ($wrapper.height());
			var p_t = isNaN(parseFloat($wrapper.css('padding-top'))) ? 0 : parseFloat($wrapper.css('padding-top'));
			var p_b = isNaN(parseFloat($wrapper.css('padding-bottom'))) ? 0 : parseFloat($wrapper.css('padding-bottom'));
			var arrow_top_position = ((wrapper_height + 1 * p_t + 1 * p_b - arrow_height) / 2 ) + 1 * arrow_middle_offset;
			
			$left_arrow.css({
				'top': arrow_top_position,
				'left': '-64px',
				'opacity': arrow_opacity
			});
			$right_arrow.css({
				'top': arrow_top_position,
				'right': '-64px',
				'opacity': arrow_opacity
			});
			
			if(show_arrows == 0) {//never show arrows
				$left_arrow.remove();
				$right_arrow.remove();
			}
			else if(show_arrows == 1) {//show on hover
				$wrapper.hover(function() {
					cis_show_arrows($wrapper);
				}, function() {
					cis_hide_arrows($wrapper);
				})
			}
			else {
				cis_show_arrows($wrapper);
			}
		});
	};
	setTimeout(function() {
		cis_prepare_arrows();
	},1200);
	
	var cis_arrows_timeout1 = '';
	var cis_arrows_timeout2 = '';
	function cis_show_arrows($wrapper) {
		//clear timeouts
		clearTimeout(cis_arrows_timeout1);
		clearTimeout(cis_arrows_timeout2);
		
		var $left_arrow = $wrapper.find('.cis_button_left');
		var $right_arrow = $wrapper.find('.cis_button_right');
		
		var corner_offset = $left_arrow.attr("corner_offset");
		
		var animation_time = 400;
		var start_offset = -64;
		var effect = 'easeOutBack';
		
		cis_arrows_timeout1 = setTimeout(function() {
			$left_arrow.stop(true,false).animate({
				'left': corner_offset
			},animation_time,effect);
			
			$right_arrow.stop(true,false).animate({
				'right': corner_offset
			},animation_time,effect);
		},100);
		
	};
	function cis_hide_arrows($wrapper) {
		//clear timeouts
		clearTimeout(cis_arrows_timeout1);
		clearTimeout(cis_arrows_timeout2);
		
		var $left_arrow = $wrapper.find('.cis_button_left');
		var $right_arrow = $wrapper.find('.cis_button_right');
		
		var animation_time = 300;
		var start_offset = -64;
		var effect = 'easeInBack';
		
		cis_arrows_timeout2 = setTimeout(function() {
			$left_arrow.stop(true,false).animate({
				'left': start_offset
			},animation_time,effect);
			
			$right_arrow.stop(true,false).animate({
				'right': start_offset
			},animation_time,effect);
		},200)
	};
	
//mousewheel**************************************************************
	$('.cis_images_row').mousewheel(function(objEvent, intDelta) {
		if($(this).hasClass('cis_scrolling_vertical'))
			return;
		if(intDelta > 0)
			cis_move_images_holder_left($(this).find('.cis_images_holder'));
		else 
			cis_move_images_holder_right($(this).find('.cis_images_holder'));
	});
	
	setTimeout(function() {
		//cis_move_images_holder_right($('.cis_images_holder'));
	},250);
	
	//function to move left

	var effect_type = 'swing';
	var cis_clear_timeout = '';
	var cis_switch_move_direction = false;
	
	function cis_move_images_holder_left($wrapper) {
		
		//get slider data
		var slider_data = $wrapper.parents('.cis_main_wrapper ').find('.cis_moving_data').html();
		var slider_data_array = slider_data.split(',');
		var delta_offset = parseInt(slider_data_array[0]);
		var move_speed_time = parseInt(slider_data_array[1]); 
		var ease_effect = parseInt(slider_data_array[2]);
		
		clearTimeout(cis_clear_timeout);
		$('.cis_images_holder').addClass('cis_scrolling');
		cis_clear_timeout = setTimeout(function() {
			$('.cis_images_holder').removeClass('cis_scrolling');
		},move_speed_time);
		
		var screen_w = parseFloat($wrapper.parent('div').width());
		var total_w = parseFloat($wrapper.width());
		var curr_left = parseFloat($wrapper.css('margin-left'));
		curr_left -= delta_offset;
		
		//check if end
		if(Math.abs(curr_left) + 1 * screen_w >= total_w) {
			var desired_left = screen_w - total_w;
			var desired_left_1 = desired_left;
			desired_left_1 = (total_w < screen_w) ? desired_left_1 + ease_effect * 1 : desired_left_1 - ease_effect * 1; 
			
			if(total_w < screen_w && !cis_switch_move_direction) {
				cis_switch_move_direction = true;
				cis_move_images_holder_right($wrapper);
				cis_switch_move_direction = false;
				return;
			}
			
			//calculate last point speed
			var curr_left_final = parseFloat($wrapper.css('margin-left'));
			var move_speed_time_final = Math.abs(curr_left_final - desired_left_1) * move_speed_time * 1.2  / delta_offset;
			$wrapper.stop(true,false).animate({
				'margin-left': desired_left_1
			},move_speed_time_final,effect_type,function() {
				$(this).stop().animate({
					'margin-left': desired_left
				},move_speed_time,'easeOutBack')
			});
			
			return 'end';
		}
		else {
			$wrapper.stop(true,false).animate({
				'margin-left': curr_left
			},move_speed_time,effect_type);
		}
		
	};
	function cis_move_images_holder_right($wrapper) {
		
		//get slider data
		var slider_data = $wrapper.parents('.cis_main_wrapper ').find('.cis_moving_data').html();
		var slider_data_array = slider_data.split(',');
		var delta_offset = parseInt(slider_data_array[0]);
		var move_speed_time = parseInt(slider_data_array[1]); 
		var ease_effect = parseInt(slider_data_array[2]);
		
		clearTimeout(cis_clear_timeout);
		$('.cis_images_holder').addClass('cis_scrolling');
		cis_clear_timeout = setTimeout(function() {
			$('.cis_images_holder').removeClass('cis_scrolling');
		},move_speed_time);
		
		
		var screen_w = parseFloat($wrapper.parent('div').width());
		var total_w = parseFloat($wrapper.width());
		var curr_left = parseFloat($wrapper.css('margin-left'));
		curr_left += delta_offset;
		
		//check if start
		if(curr_left >= 0) {
			var desired_left = 0;
			var desired_left_1 = desired_left;
			desired_left_1 = (total_w < screen_w) ? desired_left_1 - ease_effect * 1 : desired_left_1 + ease_effect * 1;
			
			if(total_w < screen_w && !cis_switch_move_direction) {
				cis_switch_move_direction = true;
				var r = cis_move_images_holder_left($wrapper);
				cis_switch_move_direction = false;
				return r;
			}
			
			//calculate last point speed
			var curr_left_final = parseFloat($wrapper.css('margin-left'));
			var move_speed_time_final = Math.abs(curr_left_final - desired_left_1) * move_speed_time * 1.2 / delta_offset;
			$wrapper.stop(true,false).animate({
				'margin-left': desired_left_1
			},move_speed_time_final,effect_type,function() {
				$(this).stop().animate({
					'margin-left': desired_left
				},move_speed_time,'easeOutBack')
			});
			
			return 'end';
		}
		else {
			$wrapper.stop().animate({
				'margin-left': curr_left
			},move_speed_time,effect_type);
		}
	};
	
	//buttons
	$('.cis_button_left').click(function() {
		var $cis_wrapper = $(this).parents('.cis_images_row').find('.cis_images_holder');
		var screen_w = parseFloat($cis_wrapper.parent('div').width());
		var total_w = parseFloat($cis_wrapper.width());
		if(total_w < screen_w)
			cis_move_images_holder_left($cis_wrapper);
		else
			cis_move_images_holder_right($cis_wrapper);
	});
	$('.cis_button_right').click(function() {
		var $cis_wrapper = $(this).parents('.cis_images_row').find('.cis_images_holder');
		var screen_w = parseFloat($cis_wrapper.parent('div').width());
		var total_w = parseFloat($cis_wrapper.width());
		if(total_w < screen_w)
			cis_move_images_holder_right($cis_wrapper);
		else
			cis_move_images_holder_left($cis_wrapper);
	});
	$('.cis_button_left').hover(function() {
		$(this).animate({
			'opacity' : 1
		},300);
	},function() {
		var opacity_inactive = $(this).attr("op");
		$(this).animate({
			'opacity' : opacity_inactive
		},300);
	});
	$('.cis_button_right').hover(function() {
		$(this).animate({
			'opacity' : 1
		},300);
	},function() {
		var opacity_inactive = $(this).attr("op");
		$(this).animate({
			'opacity' : opacity_inactive
		},300);
	});
	
	//disable page scroll
	$('.cis_images_row').bind('mousewheel DOMMouseScroll', function(e) {
	    var scrollTo = null;

	    if (e.type == 'mousewheel') {
	        scrollTo = (e.originalEvent.wheelDelta * -1);
	    }
	    else if (e.type == 'DOMMouseScroll') {
	        scrollTo = 40 * e.originalEvent.detail;
	    }

	    if (scrollTo) {
	        e.preventDefault();
	        $(this).scrollTop(scrollTo + $(this).scrollTop());
	    }
	});
	
	//Items drag effect
	$('.cis_images_row img').on('dragstart', function(event) { event.preventDefault(); });
	$('.cis_row_item_overlay').on('dragstart', function(event) { event.preventDefault(); });
	
	//Globals
	var cis_posXdragStart = 0,
		cis_currentMouseX = -1,
		cis_swipe_offset = 15,
		cis_move_interval='';
	
	$('.cis_images_row').mousemove(function(event) {
		cis_currentMouseX = event.pageX;
    });
	
	$('.cis_images_row').mousedown(function(e) {
		
		//disable drag for overlay
		 if($(e.target).hasClass('cis_row_item_overlay_txt') || $(e.target).hasClass('creative_btn') || 
			$(e.target).hasClass('cis_row_item_overlay') || $(e.target).hasClass('creative_icon-white')) {
			 return;
		 }
		
		cis_posXdragStart = cis_currentMouseX;
		var $cis_wrapper = $(this).find('.cis_images_holder');
		cis_move_interval = setInterval(function() {cis_makeDrag($cis_wrapper);},10);
	});
	
	function cis_makeDrag($cis_wrapper) {
		if(cis_posXdragStart - cis_currentMouseX >= cis_swipe_offset) {
			cis_move_images_holder_left($cis_wrapper);
			cis_clear_interval();
		}
		else if(cis_currentMouseX - cis_posXdragStart >= cis_swipe_offset) {
			cis_move_images_holder_right($cis_wrapper);
			cis_clear_interval();
		}
	};
	
	$('.cis_images_row').mouseup(function() {
		cis_clear_interval();
	});
	$('.cis_images_row').mouseleave(function() {
		cis_clear_interval();
	});
	
	//clear interval
	function cis_clear_interval() {
		clearInterval(cis_move_interval);
	};
	
	//hover animation
	//calculate overlay height
	function cis_calculate_itms_height() {
		$(".cis_row_item").each(function() {
			var $cis_overlay = $(this).find('.cis_row_item_overlay');
			$cis_overlay.css({'visibility' : 'hidden','display' : 'block'});
			//var h = $cis_overlay.height();
			//$cis_overlay.css({'visibility' : 'visible','display' : 'block','height' : '0'}).attr('h',h);
		});
	};
	
	$(".cis_row_item img").load(function() {
		var $this = $(this);
		$this.attr('cis_loaded','loaded');
		var $cis_overlay = $(this).next('.cis_row_item_overlay');
		$cis_overlay.css({'visibility' : 'hidden','display' : 'block'});
		var h = $cis_overlay.height();
		$cis_overlay.css({'visibility' : 'visible','display' : 'block','height' : '0'}).attr('h',h);
		$cis_overlay.attr('cis_animation','enabled');
		
		$this.addClass('cis_loaded');
		cis_make_proccess($this);
	});
	
	function cis_make_proccess($el) {
		var item_width = $el.width();
		$el.parents('.cis_row_item').find('.cis_row_item_loader').animate({
			width: item_width
		},400,'swing',function() {
			$el.parents('.cis_row_item').find('.cis_row_item_loader').fadeOut(200,function() {
				$el.parents('.cis_row_item_inner').hide().removeClass('cis_row_hidden_element').fadeIn(200);
			});
		});
	};
	
	function cis_getRandomArbitary (min, max) {
	    return Math.random() * (max - min) + min;
	};
	
	function cis_calculate_loaders_width() {
		$('.cis_images_holder').each(function() {
			var $wrapper = $(this);
			var wrapper_width = $wrapper.parents('.cis_images_row').width();
			var items_height = $wrapper.find('.cis_row_item_loader').height();
			
			var loader_prepared_width = items_height * 1.5;
			var loader_ratio_sign = Math.random() < 0.5 ? 1 : -1;
			$wrapper.find('.cis_row_item_loader').each(function() {
				var loader_width_calculated = loader_prepared_width + loader_ratio_sign * cis_getRandomArbitary(0,20);
				$(this).width(loader_width_calculated);
				loader_ratio_sign = loader_ratio_sign == 1 ? -1 : 1;
			});
		});
	};
	cis_calculate_loaders_width();
	
	$(".cis_row_item").hover(function() {
		var animation_enabled = $(this).find('.cis_row_item_overlay').attr('cis_animation');
		if(animation_enabled != 'enabled')
			return;
		
		if(!($(this).parents('.cis_images_holder').hasClass('cis_scrolling'))) {
			var $cis_overlay = $(this).find('.cis_row_item_overlay');
			var overlay_height = parseInt($cis_overlay.attr('h'));
			$cis_overlay.stop().animate({
				height: overlay_height
			},300,'swing');
		}
	},function() {
		var animation_enabled = $(this).find('.cis_row_item_overlay').attr('cis_animation');
		if(animation_enabled != 'enabled')
			return;
		
		var $cis_overlay = $(this).find('.cis_row_item_overlay');
		$cis_overlay.stop().animate({
			height: 0
		},300,'swing');
	});
	
})
})(jQuery);