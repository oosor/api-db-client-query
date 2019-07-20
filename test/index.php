<?php
/**
 * Created by IntelliJ IDEA.
 * User: jarvis
 * Date: 18.07.19
 * Time: 23:31
 */

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');


$select = new \Oosor\ClientQuery\SelectBuilder('table_name_1');
$insert = new \Oosor\ClientQuery\InsertBuilder('table_name_2');
$update = new \Oosor\ClientQuery\UpdateBuilder('table_name_3');
$delete = new \Oosor\ClientQuery\DeleteBuilder('table_name_4');


$select
    ->columns(['*'])
    ->with('relation_table', 'first_table_col', 'relation_table_col')
    ->with('relation_table_2', 'first_table_col_2', 'relation_table_col_2', function (\Oosor\ClientQuery\Models\Build $build) {

        $build
            ->where('relation_table_2_id', 'value')
            ->whereDate('date_col', '<', '2010-01-02');

    })
    ->where(function (\Oosor\ClientQuery\Models\Build $build) {

        $build
            ->where('text_col', '=', 'value_text')
            ->whereDate('col_date', '2012-12-05')
            ->where(function (\Oosor\ClientQuery\Models\Build $build) {

                $build
                    ->orWhere('col_or_where', 'value_33')
                    ->orWhere(function (\Oosor\ClientQuery\Models\Build $build) {

                        $build
                            ->orWhereIn('col_in', [1, 3, 5])
                            ->whereDate('date_col', '>', '2018-02-19');

                    });

            })
            ->whereNotNull('not_null_col');

    })
    ->whereNull('be_null_col')
    ->orderDesc('date_col')
    ->limit(5, 10);


$insert
    ->data([
        ['col_1' => 'val_1', 'col_2' => 'val_2', 'col_3' => 'val_3'],
        ['col_1' => 'val_1_1', 'col_2' => 'val_2_2', 'col_3' => 'val_3_3'],
    ])
    ->pushData(['col_1' => 'val_1_pushed', 'col_2' => 'val_2_pushed', 'col_3' => 'val_3_pushed']);


$update
    ->data(['col_1' => 'val_1_new'])
    ->whereIn('col_2', ['val_2', 'val_2_pushed']);


$delete
    ->where('id', '>', 5);


echo json_encode($select->getResult());
// echo json_encode($insert->getResult());
// echo json_encode($update->getResult());
// echo json_encode($delete->getResult());