<?php

namespace App\Http\Controllers\V1\Trash;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class TrashIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:list_trash'];
    }

    public function __invoke(): Response
    {
        $perPage = request()->integer('perPage', 10);
        $currentPage = Paginator::resolveCurrentPage();
        $startIndex = ($currentPage - 1) * $perPage;

        $unionQuery = "(
  SELECT
    f.id,
    f.name,
    f.deleted_at,
    u.id AS user_id,
    CONCAT(u.first_name, ' ', u.last_name) AS user_name,
    'tenant.families.restore' AS restore_url,
    'tenant.families.force-delete' AS force_delete_url,
    'family' AS type
  FROM
    families f
    LEFT JOIN users u ON f.deleted_by = u.id
  WHERE
    f.deleted_at IS NOT NULL
    AND f.tenant_id = :tenant_id
)
UNION ALL
  (
    SELECT
      m.id,
      CONCAT(m.first_name, ' ', m.last_name) AS name,
      m.deleted_at,
      u.id AS user_id,
      CONCAT(u.first_name, ' ', u.last_name) AS user_name,
      'tenant.members.restore' AS restore_url,
      'tenant.members.force-delete' AS force_delete_url,
      'member' AS type
    FROM
      users m
      LEFT JOIN users u ON m.deleted_by = u.id
    WHERE
      m.deleted_at IS NOT NULL
      AND m.tenant_id = :tenant_id
  )
UNION ALL
  (
    SELECT
      z.id,
      z.name,
      z.deleted_at,
      u.id AS user_id,
      CONCAT(u.first_name, ' ', u.last_name) AS user_name,
      'tenant.zones.restore' AS restore_url,
      'tenant.zones.force-delete' AS force_delete_url,
      'zone' AS type
    FROM
      zones z
      LEFT JOIN users u ON z.deleted_by = u.id
    WHERE
      z.deleted_at IS NOT NULL
      AND z.tenant_id = :tenant_id
  )
UNION ALL
  (
    SELECT
      b.id,
      b.name,
      b.deleted_at,
      u.id AS user_id,
      CONCAT(u.first_name, ' ', u.last_name) AS user_name,
      'tenant.branches.restore' AS restore_url,
      'tenant.branches.force-delete' AS force_delete_url,
      'branch' AS type
    FROM
      branches b
      LEFT JOIN users u ON b.deleted_by = u.id
    WHERE
      b.deleted_at IS NOT NULL
      AND b.tenant_id = :tenant_id
  )
UNION ALL
  (
    SELECT
      n.id,
      n.subject as name,
      n.deleted_at,
      u.id AS user_id,
      CONCAT(u.first_name, ' ', u.last_name) AS user_name,
      'tenant.needs.restore' AS restore_url,
      'tenant.needs.force-delete' AS force_delete_url,
      'need' AS type
    FROM
      needs n
      LEFT JOIN users u ON n.deleted_by = u.id
    WHERE
      n.deleted_at IS NOT NULL
      AND n.tenant_id = :tenant_id
  )
UNION ALL
  (
    SELECT
      s.id,
      s.name,
      s.deleted_at,
      u.id AS user_id,
      CONCAT(u.first_name, ' ', u.last_name) AS user_name,
      'tenant.schools.restore' AS restore_url,
      'tenant.schools.force-delete' AS force_delete_url,
      'school' AS type
    FROM
      private_schools s
      LEFT JOIN users u ON s.deleted_by = u.id
    WHERE
      s.deleted_at IS NOT NULL
      AND s.tenant_id = :tenant_id
  )
UNION ALL
  (
    SELECT
      fin.id,
      CASE WHEN fin.amount > 0 THEN 'income' ELSE 'expense' END AS name,
      fin.deleted_at,
      u.id AS user_id,
      CONCAT(u.first_name, ' ', u.last_name) AS user_name,
      'tenant.financial.restore' AS restore_url,
      'tenant.financial.force-delete' AS force_delete_url,
      'finance' AS type
    FROM
      finances fin
      LEFT JOIN users u ON fin.deleted_by = u.id
    WHERE
      fin.deleted_at IS NOT NULL
      AND fin.tenant_id = :tenant_id
  )
";
        $items = DB::table(DB::raw("({$unionQuery}) AS temp_table"))
            ->offset($startIndex)
            ->limit($perPage)
            ->orderByDesc('deleted_at')
            ->setBindings(['tenant_id' => tenant('id')])
            ->get();

        $totalItems = DB::table(DB::raw("({$unionQuery}) AS temp_table"))
            ->orderByDesc('deleted_at')
            ->setBindings(['tenant_id' => tenant('id')])
            ->count();

        $paginated = (new LengthAwarePaginator(
            $items,
            $totalItems,
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()],
        ));

        $data = $paginated->toArray();

        $data['meta'] = [
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'total' => $paginated->total(),
            'per_page' => $paginated->perPage(),
            'from' => $paginated->firstItem(),
            'to' => $paginated->lastItem(),
            'path' => $paginated->path(),
        ];

        return Inertia::render('Tenant/trash/TrashIndexPage', [
            'items' => $data,
            'params' => getParams(),
        ]);
    }
}
