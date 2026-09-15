<?php

namespace Tests\Feature;

use App\Http\Controllers\DashboardAsesorController;
use ReflectionMethod;
use Tests\TestCase;

class DashboardAdvisorMonthlySalesQueryTest extends TestCase
{
    public function test_monthly_sales_queries_group_by_the_month_number_used_for_sorting(): void
    {
        $controller = new DashboardAsesorController();
        $method = new ReflectionMethod($controller, 'monthlySalesQuery');
        $method->setAccessible(true);

        foreach (['COUNT(*)', 'SUM(precio)'] as $aggregateExpression) {
            $sql = $method->invoke($controller, $aggregateExpression)->toSql();

            $this->assertStringContainsString('group by year, month, meses.mes, meses.numero', $sql);
            $this->assertStringContainsString('order by meses.numero asc', $sql);
        }
    }
}
