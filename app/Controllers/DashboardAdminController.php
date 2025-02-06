<?php

    class DashboardAdminController extends BaseController
    {
        public function index()
        {
            [$monthlyTeachers, $monthlyTeachersDiff] = $this->monthlyTeachers();
            $pendingVerifications = Teacher::pendingsCount();
            [$monthlyActiveStudents, $activeStudentsRatio] = $this->monthlyActiveStudents();
            $bannedStudentsCount = Student::bannedStudentsCount();
            [$teachersInscriptionsGrowth, $studentsInscriptionsGrowth] = $this->getLastSixMonthsInscriptions();
            $popularCategories = Category::popularCategories();
            $recentActivities = $this->getRecentActivities(3);
            
            $this->render("/",
                compact(
                'monthlyTeachers', 'monthlyTeachersDiff',
                'pendingVerifications', 'monthlyActiveStudents',
                'activeStudentsRatio', 'bannedStudentsCount', 'teachersInscriptionsGrowth',
                'studentsInscriptionsGrowth', 'popularCategories', 'recentActivities'
            ));
        }

        private function monthlyTeachers(){
            $startMonth = date('Y-m-01');
            $endMonth = date('Y-m-t');

            $lastMonthStart = date('Y-m-01', strtotime('-1 month'));
            $lastMonthEnd = date('Y-m-t', strtotime('-1 month'));

            $monthInscriptions = Teacher::getInscriptionsBetween($startMonth, $endMonth);
            $lastMonthInsriptions = Teacher::getInscriptionsBetween($lastMonthStart, $lastMonthEnd);

            $diff = $monthInscriptions - $lastMonthInsriptions;

            return [$monthInscriptions, $diff];
        }

        private function monthlyActiveStudents(){
            $startMonth = date('Y-m-01');
            $endMonth = date('Y-m-t');

            $lastMonthStart = date('Y-m-01', strtotime('-1 month'));
            $lastMonthEnd = date('Y-m-t', strtotime('-1 month'));

            $monthActiveStudents = Student::activeStudentsBetween($startMonth, $endMonth);
            $lastMonthActiveStudents = Student::activeStudentsBetween($lastMonthStart, $lastMonthEnd);

            $ratio = 100;
            if($lastMonthActiveStudents > 0){
                $ratio = ($monthActiveStudents - $lastMonthActiveStudents) / $lastMonthActiveStudents * 100;
            }

            return [$monthActiveStudents, $ratio];
        }

        private function getLastSixMonthsInscriptions()
        {
            $teachersGrowth = [];
            $studentsGrowth = [];
            for ($i = 5; $i >= 0; $i--) {
                $startDate = date('Y-m-01', strtotime("-$i months"));
                $endDate = date('Y-m-t', strtotime("-$i months"));
                $monthLabel = date('M', strtotime("-$i months"));

                $teachersGrowth[$monthLabel] = Teacher::getInscriptionsBetween($startDate, $endDate);
                $studentsGrowth[$monthLabel] = Student::getInscriptionsBetween($startDate, $endDate);
            }

            return [$teachersGrowth, $studentsGrowth];
        }

        private function getRecentActivities($limit = 3)
        {
            $recentVerifications = Teacher::getRecentVerifications($limit);
            $recentCourses = Course::getRecentCourses($limit);
            $recentCategories = Category::getRecentCategories($limit);
            
            $activities = [];
            foreach ($recentVerifications as $teacher) {
                $activities[] = [
                    'type' => 'verification',
                    'message' => 'New teacher verification request from ' . $teacher->getFullName(),
                    'created_at' => $teacher->getCreatedAt(),
                ];
            }

            foreach ($recentCourses as $course) {
                $activities[] = [
                    'type' => 'course',
                    'message' => 'New course added: ' . $course->getTitle(),
                    'created_at' => $course->getCreatedAt(),
                ];
            }

            foreach ($recentCategories as $category) {
                $activities[] = [
                    'type' => 'category',
                    'message' => 'New category added "' . $category->getName() . '" Added',
                    'created_at' => $category->getCreatedAt(),
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