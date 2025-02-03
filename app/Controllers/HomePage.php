<?php

    class HomePage extends BaseController
    {
        public function index()
        {
            $categories = Category::popularCategories();
            $topThreeCourses = Course::topCourses(3);
            $topTags = Tag::getPopularTags(6);

            $this->render("/", compact("categories", "topThreeCourses", "topTags"));
        }
    }