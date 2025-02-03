<?php
    class DashboardTeacherPage extends BaseController
    {
        public function index()
        {
            [$monthProfit, $ratioProfit] = $this->monthProfit();
            [$monthEnrollments, $diffEnrollments] = $this->monthEnrollments();
            $studentsCount = Student::studentsCountOfTeacher(user()->getId());
            $averageRate = Rate::teacherAvgRate(user()->getId());

            $lastSixMonthsEnrollments = $this->getLastSixMonthsEnrollments();
            $popularCategories = Category::popularCategories();
            $topCourse = Course::topTeacherCourse(user()->getId());
            $recentActivities = $this->getRecentActivities(3);
            
            $this->render("/",
                compact(
                'monthProfit', 'ratioProfit',
                'monthEnrollments', 'diffEnrollments',
                'studentsCount', 'averageRate', 'lastSixMonthsEnrollments',
                'popularCategories', 'topCourse', 'recentActivities'
            ));
        }

        private function monthProfit(){
            $startMonth = date('Y-m-01');
            $endMonth = date('Y-m-t');

            $lastMonthStart = date('Y-m-01', strtotime('-1 month'));
            $lastMonthEnd = date('Y-m-t', strtotime('-1 month'));

            $monthProfit = Course::getProfitsOfTeacherBetween($startMonth, $endMonth, user()->getId());
            $lastMonthProfit = Course::getProfitsOfTeacherBetween($lastMonthStart, $lastMonthEnd, user()->getId());

            $ratio = 100;
            if($lastMonthProfit > 0){
                $ratio = ($monthProfit - $lastMonthProfit) / $lastMonthProfit * 100;
            }
            if ($monthProfit == 0) {
                $ratio = 0;
            }

            return [$monthProfit, $ratio];
        }

        private function monthEnrollments(){
            $startMonth = date('Y-m-01');
            $endMonth = date('Y-m-t');

            $lastMonthStart = date('Y-m-01', strtotime('-1 month'));
            $lastMonthEnd = date('Y-m-t', strtotime('-1 month'));

            $monthEnrollments = Enrollment::countBetween($startMonth, $endMonth, user()->getId());
            $lastMonthEnrollments = Enrollment::countBetween($lastMonthStart, $lastMonthEnd, user()->getId());

            $diff = $monthEnrollments - $lastMonthEnrollments;

            return [$monthEnrollments, $diff];
        }

        private function getLastSixMonthsEnrollments()
        {
            $enrollments = [];
            for ($i = 5; $i >= 0; $i--) {
                $startDate = date('Y-m-01', strtotime("-$i months"));
                $endDate = date('Y-m-t', strtotime("-$i months"));
                $monthLabel = date('M', strtotime("-$i months"));

                $monthEnrollment = Enrollment::countBetween($startDate, $endDate, user()->getId());

                $enrollments[$monthLabel] = $monthEnrollment;
            }

            return $enrollments;
        }

        private function getRecentActivities($limit = 3)
        {
            $recentEnrollments = Enrollment::getRecentEnrollments($limit, user()->getId());
            $recentRatings = Rate::getRecentRates($limit, user()->getId());
            
            $activities = [];
            foreach ($recentEnrollments as $enrollment) {
                $activities[] = [
                    'type' => 'enrollment',
                    'message' => 'New enrollment: ' . $enrollment->getCourseTitle(),
                    'created_at' => $enrollment->getCreatedAt(),
                ];
            }

            foreach ($recentRatings as $rate) {
                $activities[] = [
                    'type' => 'rate',
                    'message' => 'New 5-star rate: ' . $rate->getCourseTitle(),
                    'created_at' => $rate->getCreatedAt(),
                ];
            }

            // sort by date
            usort($activities, function($a, $b){
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            // take 5 most recent
            $activities = array_slice($activities, 0, $limit);

            return $activities;
        }
    }