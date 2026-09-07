<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUiThemeToUsersTable extends Migration
{
    /**
     * Add the preference without touching existing user records.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'ui_theme')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('ui_theme', 10)->default('light');
        });
    }

    /**
     * Preferences are intentionally retained on rollback to avoid data loss.
     *
     * @return void
     */
    public function down()
    {
        // Intentionally non-destructive. Do not remove ui_theme or saved preferences.
    }
}
