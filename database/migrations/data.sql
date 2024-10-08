-- up
-- Table category
CREATE TABLE
    `category` (
        `id` VARCHAR(36) PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL,
        `parent_id` VARCHAR(36) DEFAULT NULL,
        `description` TEXT NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`)
    );

INSERT INTO
    `category` (`id`, `name`, `description`, `parent_id`)
VALUES
    (
        '1c2a3b4d-5e6f-7a8b-9c0d-1e2f3a4b5c6d',
        'Technology',
        'Ipsum dolor sit amet',
        NULL
    ),
    (
        '2c3d4e5f-6a7b-8c9d-0e1f-2a3b4c5d6e7f',
        'Software Development',
        'Ipsum dolor sit amet',
        '1c2a3b4d-5e6f-7a8b-9c0d-1e2f3a4b5c6d'
    ),
    (
        '3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f8a',
        'Hardware Engineering 2',
        'Ipsum dolor sit amet',
        '2c3d4e5f-6a7b-8c9d-0e1f-2a3b4c5d6e7f'
    ),
    (
        '3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f82',
        'Hardware Engineering 3',
        'Ipsum dolor sit amet',
        '3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f8a'
    ),
    (
        '4e5f6a7b-8c9d-0e1f-2a3b-4c5d6e7f8a9b',
        'Education',
        'Ipsum dolor sit amet',
        NULL
    ),
    (
        '5f6a7b8c-9d0e-1f2a-3b4c-5d6e7f8a9b0c',
        'Higher Education',
        'Ipsum dolor sit amet',
        '4e5f6a7b-8c9d-0e1f-2a3b-4c5d6e7f8a9b'
    ),
    (
        '6a7b8c9d-0e1f-2a3b-4c5d-6e7f8a9b0c1d',
        'K-12 Education',
        'Ipsum dolor sit amet',
        '4e5f6a7b-8c9d-0e1f-2a3b-4c5d6e7f8a9b'
    ),
    (
        '7b8c9d0e-1f2a-3b4c-5d6e-7f8a9b0c1d2e',
        'Health & Wellness',
        'Ipsum dolor sit amet',
        NULL
    ),
    (
        '8c9d0e1f-2a3b-4c5d-6e7f-8a9b0c1d2e3f',
        'Fitness & Nutrition',
        'Ipsum dolor sit amet',
        '7b8c9d0e-1f2a-3b4c-5d6e-7f8a9b0c1d2e'
    ),
    (
        '9d0e1f2a-3b4c-5d6e-7f8a-9b0c1d2e3f4a',
        'Mental Health',
        'Ipsum dolor sit amet',
        '7b8c9d0e-1f2a-3b4c-5d6e-7f8a9b0c1d2e'
    ),
    (
        '0e1f2a3b-4c5d-6e7f-8a9b-0c1d2e3f4a5b',
        'Arts & Entertainment',
        'Ipsum dolor sit amet',
        NULL
    ),
    (
        '1f2a3b4c-5d6e-7f8a-9b0c-1d2e3f4a5b6c',
        'Visual Arts',
        'Ipsum dolor sit amet',
        '0e1f2a3b-4c5d-6e7f-8a9b-0c1d2e3f4a5b'
    ),
    (
        '2a3b4c5d-6e7f-8a9b-0c1d-2e3f4a5b6c7d',
        'Performing Arts',
        'Ipsum dolor sit amet',
        '0e1f2a3b-4c5d-6e7f-8a9b-0c1d2e3f4a5b'
    ),
    (
        '3b4c5d6e-7f8a-9b0c-1d2e-3f4a5b6c7d8e',
        'Science & Nature',
        'Ipsum dolor sit amet',
        NULL
    ),
    (
        '4c5d6e7f-8a9b-0c1d-2e3f-4a5b6c7d8e9f',
        'Biology',
        'Ipsum dolor sit amet',
        '3b4c5d6e-7f8a-9b0c-1d2e-3f4a5b6c7d8e'
    ),
    (
        '5d6e7f8a-9b0c-1d2e-3f4a-5b6c7d8e9f0a',
        'Physics',
        'Ipsum dolor sit amet',
        '3b4c5d6e-7f8a-9b0c-1d2e-3f4a5b6c7d8e'
    ),
    (
        '6e7f8a9b-0c1d-2e3f-4a5b-6c7d8e9f0a1b',
        'Food & Cooking',
        'Ipsum dolor sit amet',
        NULL
    ),
    (
        '7f8a9b0c-1d2e-3f4a-5b6c-7d8e9f0a1b2c',
        'Recipes',
        'Ipsum dolor sit amet',
        '6e7f8a9b-0c1d-2e3f-4a5b-6c7d8e9f0a1b'
    ),
    (
        '8a9b0c1d-2e3f-4a5b-6c7d-8e9f0a1b2c3d',
        'Culinary Techniques',
        'Ipsum dolor sit amet',
        '6e7f8a9b-0c1d-2e3f-4a5b-6c7d8e9f0a1b'
    ),
    (
        '9b0c1d2e-3f4a-5b6c-7d8e-9f0a1b2c3d4e',
        'Travel & Tourism',
        'Ipsum dolor sit amet',
        NULL
    ),
    (
        '0c1d2e3f-4a5b-6c7d-8e9f-0a1b2c3d4e5f',
        'Destinations',
        'Ipsum dolor sit amet',
        '9b0c1d2e-3f4a-5b6c-7d8e-9f0a1b2c3d4e'
    ),
    (
        '1d2e3f4a-5b6c-7d8e-9f0a-1b2c3d4e5f6a',
        'Travel Tips',
        'Ipsum dolor sit amet',
        '9b0c1d2e-3f4a-5b6c-7d8e-9f0a1b2c3d4e'
    );

-- Table course
CREATE TABLE
    `course` (
        `id` VARCHAR(36) PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `description` TEXT NOT NULL,
        `preview` VARCHAR(255) NOT NULL,
        `category_id` VARCHAR(36) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
    );

INSERT INTO
    `course` (
        `id`,
        `title`,
        `description`,
        `preview`,
        `category_id`
    )
VALUES
    (
        '8513f34b-3229-4be0-8338-7ab3e6838b75',
        'Diversity and Inclusion for a Better Business',
        'Diversity can seem like a difficult concept to incorporate into the culture of a business. Leaders often view diversity initiatives as important but see them as secondary to the day-to-day operations of a successful business. You may ask yourself, where and how do I start? In this course, we’ll look at many strategies that can help jumpstart diversity and inclusion initiatives. Through these initiatives, we can build stronger relationships that improve the overall business environment and how it functions. These relationships can drive stability, sustainability, and profitability for years to come.  ',
        'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373349028/800--v112240.jpg',
        '3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f8a'
    ),
    (
        'e42aa2dc-af14-49db-8e35-f4c58cd91176',
        'Leadership for Identity Diversity',
        'As a leader, people of many different backgrounds will look to you for guidance and security in the workplace. The individual identities within a workplace can include individuals from different racial and ethnic backgrounds, individuals with different gender and sexual identities, and individuals with different disabilities. One of the goals of a leader is to create a safe and inclusive environment for all employees. When creating an inclusive environment, it is important to be aware of who you are creating it for and what their individual needs are. Recognizing individuality and implementing inclusion practices benefit everyone and improve your business’s culture.',
        'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373371072/800--v112239.jpg',
        '3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f8a'
    ),
    (
        '4edb6eec-35b2-466d-9c5f-b864a388ea29',
        'Applying Yourself to Diverse and Inclusive Leadership',
        'Improving diversity in the workplace requires strategic planning and mindful consideration from everyone involved because inclusion in the workplace is a team effort. When a leader is a participant in change rather than a director, the culture is able to transform with them. Strategies such as improved communication, modeling positivity and adaptability, and building relationships can help make the transition smoother. Effectively changing the culture of a business requires commitment and determination, which is why it’s important to know of leadership strategies that you can use to help you build and maintain a sustainable culture of diversity and equity.\n\n',
        'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373324687/800--v112241.jpg',
        '3d4e5f6a-7b8c-9d0e-1f2a-3b4c5d6e7f82'
    ),
    (
        'ef6d226e-d4a7-4c23-abaa-36bd8e6d1eed',
        'Finance and Accounting Basics for Nonfinancial Executives',
        'Financial knowledge is vital to an executive’s role in a business, but the systems within a business can be extremely complex. Without a strong foundation of financial analytics, it can be difficult to interpret, report, or even understand a business’s financial standing. A lack of understanding can impede your ability to make educated decisions. By understanding where the data comes from and how accounting operates, you can manage your business with greater efficiency and interpret business systems more accurately. ',
        'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373312762/800--v112243.jpg',
        '4e5f6a7b-8c9d-0e1f-2a3b-4c5d6e7f8a9b'
    ),
    (
        '365481e1-f18c-45ab-aa74-062787f4d525',
        'Financial Statements and Reporting for Nonfinancial Executives',
        'Financial statements are a critical part of attracting investors. Financial reports like income statements are the hard proof of how your business is doing. Properly interpreting these statements can provide a stronger understanding of your business’s performance. This can also assist your company when acquiring new investments and making strategic business decisions. Your reliable and precise numbers may encourage shareholders and investors to feel more confident when working with you. ',
        'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373319845/800--v112244.jpg',
        '5f6a7b8c-9d0e-1f2a-3b4c-5d6e7f8a9b0c'
    ),
    (
        '0d30b423-e809-44fd-9bf4-138262eb4cc7',
        'Financial Planning and Analysis for Nonfinancial Executives',
        'With constant market fluctuation and an unpredictable supply chain, sometimes it can be difficult to project where your business will be tomorrow. That’s where financial forecasting comes in. The data you have today can be used in various ratios and equations to create helpful financial estimates for your business. You can also use different aspects of financial and managerial accounting to better present your finances to potential and existing stakeholders. Streamlined financial reporting, planning, and analysis techniques can improve your business’s competitive strategy. ',
        'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373327593/800--v112246.jpg',
        '7b8c9d0e-1f2a-3b4c-5d6e-7f8a9b0c1d2e'
    ),
    (
        'b9bd4755-5517-4141-bf9a-836b466aeca0',
        'Valuation for Nonfinancial Executives',
        'Investments always involve a bit of risk, but you can lower that risk by analyzing your company’s current and future value. There are many options when it comes to funding a business or a project. Funding can be acquired through both debt and equity, as well as working capital. Learning the inner workings of project and relative valuation can help improve your investment decision-making skills and understand which projects will bring the best results.',
        'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373395597/800--v112241.jpg',
        '1f2a3b4c-5d6e-7f8a-9b0c-1d2e3f4a5b6c'
    ),
    (
        '6b61200d-fd97-4ff9-a9e4-f660b868f458',
        'Defining Cross-Cultural Leadership',
        'The modern business landscape is noticeably globalized. People from many countries and cultures work together, whether in-person or remotely. You might work in an environment like this yourself, or you likely will in the future. That’s why it’s critical for you, as a leader, to have the necessary skills to navigate cultural differences within your company. Otherwise, you might not know how best to leverage your employees’ skills. So how can you do this? How can you become a cross-cultural leader?',
        'https://cdn0.knowledgecity.com/opencontent/courses/previews/L373337574/800--v112262.jpg',
        '8a9b0c1d-2e3f-4a5b-6c7d-8e9f0a1b2c3d'
    );

-- Create view for category course count
CREATE VIEW category_course_count AS
WITH RECURSIVE CategoryHierarchy AS (
    -- Base case: Select each category by itself
    SELECT 
        id AS category_id,
        id AS root_id
    FROM 
        category
    UNION ALL
    -- Recursive case: Select subcategories
    SELECT 
        c.id AS category_id,
        ch.root_id
    FROM 
        category c
    INNER JOIN 
        CategoryHierarchy ch ON c.parent_id = ch.category_id
)
SELECT 
    ch.root_id AS category_id,
    COUNT(co.id) AS count_of_courses
FROM 
    CategoryHierarchy ch
LEFT JOIN 
    course co ON ch.category_id = co.category_id
GROUP BY 
    ch.root_id;

-- down
DROP TABLE `course`;

DROP TABLE `category`;

DROP VIEW `category_course_count`;