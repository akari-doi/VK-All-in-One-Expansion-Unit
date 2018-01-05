/*-------------------------------------------*/
/*  画像登録処理
/*-------------------------------------------*/
/*  画像削除処理
/*-------------------------------------------*/

// 画像登録処理（ ボタンに直接 onclick="javascript:vk_title_bg_image_addiditional(this);return false;" を記述している ）
if ( vk_widget_image_add == undefined ){
	var vk_widget_image_add = function(e){
		// プレビュー画像を表示するdiv
    var thumb_outer=jQuery(e).parent().children("._display");
		// 画像IDを保存するinputタグ
    var thumb_url=jQuery(e).parent().children("._form").children('._url')[0];
		var thumb_alt=jQuery(e).parent().children("._form").children('._alt')[0];
    var u=wp.media({library:{type:'image'},multiple:false}).on('select', function(e){
				u.state().get('selection').each(function(file){
					// プレビュー画像の枠の中の要素を一旦削除
					thumb_outer.children().remove();
					// ウィジェットフォームでのプレビュー画像を設定
					// thumb_outer.append(jQuery('<img class="admin_widget_thumb">').attr('src',f.toJSON().url).attr('alt',f.toJSON().url));
					thumb_outer.append('<img class="admin_widget_thumb" src="'+ file.toJSON().url +'" alt="'+ file.toJSON().title +'" />');
					/*
					file.toJSON().id で id
					file.toJSON().title で titleが返せる
					 */
					// hiddeになってるinputタグのvalueも変更
					jQuery(thumb_url).val(file.toJSON().url);
					jQuery(thumb_alt).val(file.toJSON().title).change();
				});
    });
    u.open();
};
}

// 画像削除処理（ ボタンに直接 onclick="javascript:vk_title_bg_image_delete(this);return false;" を記述している ）
if ( vk_widget_image_del == undefined ){
	var vk_widget_image_del = function(e){
		// プレビュー画像を表示するdiv
		var thumb_outer=jQuery(e).parent().children("._display");
		// 画像IDを保存するinputタグ
		var thumb_input=jQuery(e).parent().children("._form").children('._url')[0];
		// プレビュー画像のimgタグを削除
		thumb_outer.children().remove();
		// w.attr("value","");
		jQuery(e).parent().children("._form").children('._alt').attr("value","");
		jQuery(e).parent().children("._form").children('._url').attr("value","").change();
	};
}






( function( $, api ) {
    api( 'blogname', function( setting ) {
        setting.bind( function( value ) {
            $( '.site-title a' ).text( value );
        } );
    } );
} ( jQuery, wp.customize ) );


jQuery(document).ready(function(i){


		    // Short-circuit selective refresh events if not in customizer preview or pre-4.5.
	    // if ( 'undefined' === typeof wp || ! wp.customize || ! wp.customize.selectiveRefresh ) {
	    //     return;
	    // }

	console.log('そもそもここは読んでる？');

			// // テキストが変更された時
			// wp.customize( 'lightning_theme_options[header_top_contact_txt]', function( contact_txt_value ) {
			// 	contact_txt_value.bind( function( contact_txt_new_val ) {
			// 		// グローバルのテキストを書き換えておく
			// 		// contact_txt = contact_txt_value.get();
			// 		contact_txt = contact_txt_new_val;
			// 		// console.log( contact_txt_new_val + ' : ' + contact_url );
			// 		header_top_contact_btn( contact_txt, contact_url );
			// 	} );
			// } );

	    // Re-load Twitter widgets when a partial is rendered.
	    wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
				console.log('placement:'+placement);
	        if ( placement.container ) {

						console.log('_|＼○_ﾋｬｯ ε=＼＿○ﾉ ﾎｰｳ!!');
	            // twttr.widgets.load( placement.container[0] );
	        }
	    } );

	    // Refresh a moved partial containing a Twitter timeline iframe, since it has to be re-built.
	    wp.customize.selectiveRefresh.bind( 'partial-content-moved', function( placement ) {
	        if ( placement.container && placement.container.find( 'iframe.twitter-timeline:not([src]):first' ).length ) {
	            placement.partial.refresh();
	        }
	    } );


/////////////////






	console.log('うえ-----------い');
	jQuery('.color_picker_wrap').click(function(){
		console.log('うい-----------い');
	});

	// $(document).off('click','p');
	// $('.color_picker_wrap').on('click','input',function(){
	//      console.log('押した');
	// });
	// $('.color_picker_wrap').off('click','.wp-picker-clear');
	// jQuery('.wp-picker-clear').click();
	//
		// $(document).on('click','.color_picker_wrap',function(e){
		//       console.log('外を押した');
		// 			jQuery(e).find('input.wp-color-picker').attr("value","").change();
		// });
		$('.color_picker_wrap').click(function(){
			console.log('外２を押した');
			jQuery(this).find('input.wp-color-picker').attr("value","").change();
		});
		// $(document).on('click','p',function(){
		// 			console.log('pタグ押した');
		// });
		$(document).on('click','.wp-picker-input-wrap',function(){
					console.log('wp-picker-input-wrap タグ押した');
		});
	jQuery('.wp-picker-clear').ready(function(i){
		console.log('クリア読みました');
		$('.wp-picker-clear').on('click',function(){
					console.log('クリア押した');
		});
		$('.wp-picker-clear').click(function(){
					console.log('クリア押した');
		});
	});
		// $(document).on('click','.wp-picker-input-wrap',function(){
		// 			console.log('wp-picker-input-wrap タグ押した');
		// });
    //
		// $(document).on('click','.wp-picker-clear',function(){
		// 			console.log('クリア押した');
		// });
});
