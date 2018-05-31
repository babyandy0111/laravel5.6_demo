<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->nullable();
			$table->integer('user_category_id')->nullable()->index('post_user_category_id');
			$table->integer('category_id')->nullable()->index('index_posts_on_category_id');
			$table->string('title')->nullable();
			$table->text('content', 16777215)->nullable();
			$table->string('password')->nullable()->comment('有加密的文章才會有值');
			$table->string('password_tip')->nullable()->comment('密碼提示');
			$table->boolean('post_status')->nullable()->default(0)->index('index_posts_on_post_status')->comment('0: 草稿 1:公開 2:隱藏 3:密碼');
			$table->boolean('reply_status')->nullable()->default(0)->index('index_posts_on_reply_status')->comment('可否回覆 0:可 1:不可 3:登入者才能回覆');
			$table->boolean('is_top')->nullable()->default(0)->comment('置頂');
			$table->integer('replies_count')->nullable()->default(0)->comment('留言篇數');
			$table->integer('quote_posts_count')->nullable()->default(0)->comment('已沒有在用');
			$table->text('cover_img_url', 65535)->nullable()->comment('封面圖片(90x90)對應post_cover');
			$table->boolean('not_sync_to_forum')->nullable()->default(0);
			$table->boolean('not_sync_to_fit')->nullable()->default(0);
			$table->dateTime('published_at')->nullable()->comment('文章上線的時間');
			$table->timestamps();
			$table->boolean('is_enabled')->nullable()->default(1)->comment('0: 已刪除的文章');
			$table->integer('old_amount')->nullable()->default(0);
			$table->string('old_post_list_img')->nullable();
			$table->string('keywords')->nullable();
			$table->string('from')->nullable();
			$table->integer('from_id')->nullable();
			$table->text('from_url', 65535)->nullable();
			$table->text('tags', 65535)->nullable();
			$table->index(['published_at','post_status'], 'post_published_at_and_status');
			$table->index(['user_id','published_at','post_status'], 'post_user_and_published_at_and_status');
			$table->index(['from','from_id'], 'index_posts_on_from_and_from_id');
			$table->index(['user_id','is_enabled'], 'index_userid_and_isenabled');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
