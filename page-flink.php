<?php
/*
Template Name: 自助友情链接
*/
get_header();?>

<?php 

//  --自助友链--
	if (isset($_POST['blink_form']) && $_POST['blink_form'] == 'send') {
		global $wpdb;
	
		// 表单变量初始化
		$link_name = isset($_POST['blink_name']) ? trim(htmlspecialchars($_POST['blink_name'], ENT_QUOTES)) : '';
		$link_url = isset($_POST['blink_url']) ? trim(htmlspecialchars($_POST['blink_url'], ENT_QUOTES)) : '';
		$link_description = isset($_POST['blink_lianxi']) ? trim(htmlspecialchars($_POST['blink_lianxi'], ENT_QUOTES)) : '';
		$link_image = isset($_POST['blink_image']) ? trim(htmlspecialchars($_POST['blink_image'], ENT_QUOTES)) : '';
		
		// 联系方式
		$link_target = "_blank";
		$link_visible = "N";
		
		// 表示链接默认不可见
	
		// 表单项数据验证
		if (empty($link_name) || mb_strlen($link_name) > 20) {
			wp_die('链接名称是必填项哦，长度不能超过30字<br><a href="javascript:history.go(-1);">点此返回</a>');
		}
	
		if (empty($link_url) || strlen($link_url) > 60 || !preg_match("/^(https?:\/\/)?(((www\.)?[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)?\.([a-zA-Z]+))|(([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5]))(\:\d{0,4})?)(\/[\w- .\/?%&=]*)?$/i", $link_url)) {
			//验证url
			wp_die('链接地址必须填写<br><a href="javascript:history.go(-1);">点此返回</a>');
		}
	
		$sql_link = $wpdb->insert(
			$wpdb->links,
			array(
				'link_name' => '【待审核】- '.$link_name,
				// 'link_name' => $link_name,
				'link_url' => $link_url,
				'link_target' => $link_target,
				'link_description' => $link_description,
				'link_visible' => $link_visible,
				
			)
		);
	
		$result = $wpdb->get_results($sql_link);
	
		wp_die('链接提交成功，请耐心等待站长审核！<br><style>
		a {
		    color:#1a1a1a;
		}
		</style><a href="javascript:history.go(-1);" style="color:red;" >点此返回</a>', '提交成功');
	
	}

?>
<div id="" class="wrap">
	<div id="main">
        <div class="single ease-bg-light">
            <article class="posts">
                <?php if(have_posts()) : ?>
                <?php while(have_posts()): the_post(); ?>
                <h2><?php the_title(); ?></h2>
                <div class="meta">
                    <?php EaseSingleTag(); ?>
                </div>
                <br>
                <div class="entry-content">
                    <div class="my-friend-links">
                        <h3>我的好友</h3>
                        <ul>
                        <?php wp_list_bookmarks('title_li=&categorize=0'); ?>
                        </ul>
                    </div>
                    <?php the_content(); ?>
                    
                    
                <!--表单开始-->
                <div class="comments-area">
                    <h3>自助申请友链</h3>
                    <form method="post" class="mt20" action="<?php echo $_SERVER["REQUEST_URI"];
                        ?>">
                        <input type="text" size="40" value="" class="flink-text-input" id="blink_name" placeholder="站点名称（必填，30字以内）" name="blink_name" />
                        <input type="text" size="40" value="" class="flink-text-input" id="blink_url" placeholder="站点域名（必填）" name="blink_url" />

                        <input type="text" size="40" value="" class="flink-text-input" id="blink_lianxi" placeholder="站点介绍" name="blink_lianxi" />
                        <!--<input type="text" size="40" value="" class="flink-text-input" id="blink_image" placeholder="QQ号码（用来显示链接头像）PS:正在调试，暂不可用" name="blink_image" />-->
                        <input type="hidden" value="send" name="blink_form" />
                        <button type="submit" class="flink-submit">提交申请</button>
                        <button type="reset" class="flink-submit">重新填写</button>
                    </form>
                </div>
                <!--表单结束-->
                </div>
                
                <?php endwhile; ?>
                <?php else : ?>
                <?php echo( '没有文章，去发布你的第一篇文章吧！'); ?>
                <?php endif; ?>
                
            </article>
        </div>
        <div class="ease-comment ease-bg-light">
        <?php comments_template(); ?>
        </div>
	</div>
</div>
	<?php get_footer(); ?>

