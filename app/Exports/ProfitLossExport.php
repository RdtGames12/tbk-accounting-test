<?php

namespace App\Exports;

use App\Models\Coa;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ProfitLossExport implements
    FromArray,
    ShouldAutoSize,
    WithStyles
{
    protected array $rowMeta = [];
    protected ?string $startDate;
    protected ?string $endDate;

    public function __construct(
        $startDate = null,
        $endDate = null
    )
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function array(): array
    {
        $monthQuery = Transaction::query();

        if ($this->startDate && $this->endDate) {
            $monthQuery->whereBetween(
                'transaction_date',
                [
                    $this->startDate,
                    $this->endDate
                ]
            );
        }

        $months = $monthQuery
            ->selectRaw(
                "DATE_FORMAT(transaction_date,'%Y-%m') as month"
            )
            ->distinct()
            ->orderBy('month')
            ->pluck('month')
            ->toArray();

        $rows = [];
        $this->rowMeta = [];

        $rows[] = ['Laporan Profit/Loss'];
        $this->rowMeta[] = 'title';

        $header = ['Category'];
        foreach ($months as $month) {
            $header[] = $month;
        }
        $rows[] = $header;
        $this->rowMeta[] = 'header';

        $amountRow = [''];
        foreach ($months as $month) {
            $amountRow[] = 'Amount';
        }
        $rows[] = $amountRow;
        $this->rowMeta[] = 'subheader';

        $incomeCategories  = ['Salary', 'Other Income'];
        $expenseCategories = ['Family Expense', 'Transport Expense', 'Meal Expense'];

        $incomeTotal  = array_fill_keys($months, 0);
        $expenseTotal = array_fill_keys($months, 0);

        $incomeCoas = Coa::whereHas('category', fn ($q) =>
                $q->whereIn('name', $incomeCategories)
            )
            ->with('category')
            ->orderBy('code')
            ->get();

        foreach ($incomeCoas as $coa) {
            $row = [$coa->name];

            foreach ($months as $month) {
                $query = Transaction::where(
                    'coa_id',
                    $coa->id
                )
                ->whereRaw(
                    "DATE_FORMAT(transaction_date,'%Y-%m') = ?",
                    [$month]
                );

                if ($this->startDate && $this->endDate) {
                    $query->whereBetween(
                        'transaction_date',
                        [
                            $this->startDate,
                            $this->endDate
                        ]
                    );
                }

                $amount = $query->sum('credit');

                $row[] = $amount;
                $incomeTotal[$month] += $amount;
            }

            $rows[] = $row;
            $this->rowMeta[] = 'income';
        }

        $totalIncomeRow = ['Total Income'];
        foreach ($months as $month) {
            $totalIncomeRow[] = $incomeTotal[$month];
        }
        $rows[] = $totalIncomeRow;
        $this->rowMeta[] = 'total_income';

        /*
        |----------------------------------------------------------------------
        | EXPENSE
        |----------------------------------------------------------------------
        */

        $expenseCoas = Coa::whereHas('category', fn ($q) =>
                $q->whereIn('name', $expenseCategories)
            )
            ->with('category')
            ->orderBy('code')
            ->get();

        foreach ($expenseCoas as $coa) {
            $row = [$coa->name];

            foreach ($months as $month) {
                $query = Transaction::where(
                    'coa_id',
                    $coa->id
                )
                ->whereRaw(
                    "DATE_FORMAT(transaction_date,'%Y-%m') = ?",
                    [$month]
                );

                if ($this->startDate && $this->endDate) {
                    $query->whereBetween(
                        'transaction_date',
                        [
                            $this->startDate,
                            $this->endDate
                        ]
                    );
                }

                $amount = $query->sum('debit');

                $row[] = $amount;
                $expenseTotal[$month] += $amount;
            }

            $rows[] = $row;
            $this->rowMeta[] = 'expense';
        }

        $totalExpenseRow = ['Total Expense'];
        foreach ($months as $month) {
            $totalExpenseRow[] = $expenseTotal[$month];
        }
        $rows[] = $totalExpenseRow;
        $this->rowMeta[] = 'total_expense';

        /*
        |----------------------------------------------------------------------
        | NET INCOME
        |----------------------------------------------------------------------
        */

        $netIncomeRow = ['Net Income'];
        foreach ($months as $month) {
            $netIncomeRow[] = $incomeTotal[$month] - $expenseTotal[$month];
        }
        $rows[] = $netIncomeRow;
        $this->rowMeta[] = 'net_income';

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn   = $sheet->getHighestColumn();
        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);

        $yellow      = 'FFFF00';
        $lightGreen  = 'C6EFCE';
        $darkGreen   = '70AD47';
        $lightOrange = 'FCE4D6';
        $darkOrange  = 'F4B183';

        $sheet->mergeCells('A1:' . $lastColumn . '1');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);

        $sheet->getStyle('A2:' . $lastColumn . '2')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FF0000']],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $yellow],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle('A3:' . $lastColumn . '3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $yellow],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        foreach ($this->rowMeta as $index => $type) {
            $excelRow = $index + 1;

            switch ($type) {
                case 'income':
                    $this->applyRowStyle($sheet, $excelRow, $lastColumn, $lightGreen, false);
                    break;

                case 'total_income':
                    $this->applyRowStyle($sheet, $excelRow, $lastColumn, $darkGreen, true);
                    break;

                case 'expense':
                    $this->applyRowStyle($sheet, $excelRow, $lastColumn, $lightOrange, false);
                    break;

                case 'total_expense':
                    $this->applyRowStyle($sheet, $excelRow, $lastColumn, $darkOrange, true);
                    break;

                case 'net_income':
                    $sheet->getStyle('A' . $excelRow . ':' . $lastColumn . $excelRow)
                        ->applyFromArray([
                            'font' => ['bold' => true],
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_CENTER,
                            ],
                        ]);
                    break;
            }
        }

        $firstDataRow = 4;
        $lastDataRow  = count($this->rowMeta);
        if ($lastColumnIndex > 1) {
            $dataRange = 'B' . $firstDataRow . ':' . $lastColumn . $lastDataRow;
            $sheet->getStyle($dataRange)->getNumberFormat()
                ->setFormatCode('#,##0');
        }

        $sheet->getStyle('A4:A' . $lastDataRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getColumnDimension('A')->setWidth(22);

        return [];
    }

    private function applyRowStyle(
        Worksheet $sheet,
        int $row,
        string $lastColumn,
        string $bgColor,
        bool $bold
    ): void {
        $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->applyFromArray([
            'font' => ['bold' => $bold],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $bgColor],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A' . $row)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);
    }
}