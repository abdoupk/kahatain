interface Sponsor {
    other: number
    widow: number
    widower: number
    mother_of_a_supported_childhood: number
    widowers_wife: number
    widows_husband: number
}

interface OrphansLt18 {
    baby: number
    below_school_age: number
    elementary_school: number
    middle_school: number
    high_school: number
    dismissed: number
    professionals: number
}

interface OrphansLt18AcademicSeason {
    baby: number
    below_school_age: number
    elementary_school: number
    middle_school: number
    high_school: number
    dismissed: number
    professionals: number
}

interface Orphans {
    lt_18: {
        outside_academic_season: OrphansLt18
        during_academic_season: OrphansLt18AcademicSeason
    }
    male_gt_18: {
        college_boy: number
        professional_boy: number
        unemployed: number
        worker_with_family: number
        worker_outside_family: number
        married_with_family: number
        married_outside_family: number
    }
    female_gt_18: {
        college_girl: number
        professional_girl: number
        at_home_with_no_income: number
        at_home_with_income: number
        single_female_employee: number
        married: number
        divorced: number
    }
}

interface PercentageOfContributionSponsor {
    other: number
    widow: number
    widower: number
    mother_of_a_supported_childhood: number
    widowers_wife: number
    widows_husband: number
}

interface PercentageOfContributionOrphans {
    male_gt_18: {
        college_boy: number
        worker_with_family: number
        worker_outside_family: number
        married_with_family: number
        married_outside_family: number
    }
    female_gt_18: {
        college_girl: number
        professional_girl: number
        at_home_with_income: number
        single_female_employee: number
        married: number
        divorced: number
    }
}

interface UnemployedContributionSponsor {
    other: number
    widow: number
    widower: number
    mother_of_a_supported_childhood: number
    widowers_wife: number
    widows_husband: number
}

interface UnemployedContributionOrphans {
    male_gt_18: {
        professional_boy: number
        unemployed: number
        married_with_family: number
    }
    female_gt_18: {
        at_home_with_no_income: number
    }
}

export type CalculationTableType = {
    weights: {
        sponsor: Sponsor
        orphans: Orphans
        handicapped: number
    }
    percentage_of_contribution: {
        sponsor: PercentageOfContributionSponsor
        orphans: PercentageOfContributionOrphans
    }
    unemployed_contribution: {
        sponsor: UnemployedContributionSponsor
        orphans: UnemployedContributionOrphans
    }
    handicapped_contribution: {
        income: number
        contribution: number
    }
}
