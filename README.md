# purchase-tracker
## 📝 OFFICIAL FINAL EXAM – 20 Multiple Choice Questions  
**Difficulty:** Easy to Intermediate  
**Only one correct answer per question.**  
**Answer key is provided at the bottom.**

---

### **Part I – PHP Basics & Environment**

1. What is the correct file extension for PHP scripts?  
   a) .ph  
   b) .html  
   **c) .php**  
   d) .script  

2. What does `$_FILES` represent in PHP?  
   a) An array of sessions  
   b) An array of connections  
   **c) An array containing uploaded file data**  
   d) A constant array  

3. What does `include 'file.php';` do?  
   a) Runs a SQL query  
   **b) Inserts the contents of another PHP file**  
   c) Starts a session  
   d) Creates a new cookie  

4. Which function converts special characters to HTML entities?  
   a) htmlentities()  
   b) strip_tags()  
   **c) htmlspecialchars()**  
   d) encode()  

5. Which function checks if a variable is empty?  
   **a) empty()**  
   b) isset()  
   c) is_null()  
   d) validate()  

---

### **Part II – Control Structures & Arrays**

6. Which loop structure iterates through array items?  
   a) for  
   b) while  
   **c) foreach**  
   d) switch  

7. What is the result of `true && false` in PHP?  
   a) true  
   **b) false**  
   c) null  
   d) 1  

8. How do you create an array of numbers from 1 to 5?  
   a) array[1..5]  
   b) [1,2,3,4,5]  
   c) range(1,5)  
   **d) array(1,2,3,4,5)**  

9. Which keyword breaks out of a loop in PHP?  
   a) exit  
   **b) break**  
   c) continue  
   d) stop  

10. What does `explode(',', 'a,b,c')` return?  
   a) "abc"  
   **b) array('a','b','c')**  
   c) "a b c"  
   d) array('a,b,c')  

---

### **Part III – Database & PHP Integration**

11. How do you connect to a database using PDO?  
   a) new DB()  
   **b) new PDO()**  
   c) connectPDO()  
   d) pdo_connect()  

12. Which SQL command deletes a row from a table?  
   **a) DELETE**  
   b) REMOVE  
   c) TRUNCATE  
   d) DROP  

13. Which PDO function returns the number of affected rows?  
   a) count()  
   **b) rowCount()**  
   c) getRows()  
   d) getCount()  

14. Which function removes HTML tags from a string?  
   a) htmlspecialchars()  
   **b) strip_tags()**  
   c) clean_html()  
   d) remove_html()  

15. What is SQL Injection?  
   a) JavaScript variable injection  
   b) A database schema error  
   **c) An attack that manipulates SQL queries**  
   d) A POST validation feature  

---

### **Part IV – OOP and Security**

16. Which keyword defines a class in PHP?  
   a) object  
   b) struct  
   **c) class**  
   d) define  

17. How do you access a static method in PHP?  
   a) $obj->method()  
   **b) ClassName::method()**  
   c) this->method()  
   d) self->method()  

18. What does `private` mean for a property?  
   a) It can be accessed from anywhere  
   **b) It can only be accessed within the class**  
   c) It’s a temporary variable  
   d) It’s public by default  

19. What command ends a session in PHP?  
   a) session_close()  
   b) end_session()  
   **c) session_destroy()**  
   d) unset_session()  

20. How do you protect forms from CSRF attacks?  
   a) Use GET instead of POST  
   b) Block IPs  
   **c) Use session tokens**  
   d) Disable JavaScript  


---

## 🎓 PROJECTS – BASED ON THE LAST DIGIT OF YOUR STUDENT NUMBER

> 🔢 Each student must complete **only the project** that matches the **last digit of their Student Number**.

All projects share the same structure and include:

- **User login with session**
- **CRUD for managing items**
- **File/image upload functionality**
- **Database integration using PDO**
- **Video demo required (30s max)**

---

### 📁 FOLDER STRUCTURE (FOR ALL PROJECTS)

```
/
├── login.php
├── logout.php
├── dashboard.php
├── add_item.php
├── delete_item.php
├── db.php
├── session.php
├── uploads/
│   └── (uploaded files)
├── css/
│   └── style.css
├── project-demo.mp4   <-- 🔴 This video must be in the root of your repository
└── README.md
```

---

## 🔢 PROJECT LIST

| Student Number Ends In | Project Topic |
|------------------------|---------------|
| **0** | 📚 Book Catalog – title, author, genre, **cover upload** |
| **1** | 🛍️ Purchase Tracker – product, amount, value, **receipt upload** |
| **2** | 🍽️ Recipe Manager – name, ingredients, method, **dish photo upload** |
| **3** | 🎬 Movie List – title, director, rating, **poster upload** |
| **4** | 🎵 Music Playlist – song name, artist, genre, **album cover upload** |
| **5** | ✅ Task Manager – title, description, due date, **attachment upload** |
| **6** | 📷 Photo Portfolio – title, category, description, **photo upload** |
| **7** | 🐾 Pet Register – name, breed, age, **pet photo upload** |
| **8** | 🌍 Travel Destinations – name, country, description, **image upload** |
| **9** | 🧘 Activity Schedule – activity, time, category, **illustration upload** |

---

## 📊 GRADING CRITERIA

| Section                       | Points | Notes                                                           |
|------------------------------|--------|-----------------------------------------------------------------|
| **Exam completed in README** | 2.0    | Full structure + bolded answers (right or wrong)               |
| **Project implementation**   | 5.0    | Working CRUD, image upload, session, DB                        |
| **GitHub + Demo Video OR Live Project**      | 3.0    | Proper repository, README, and 30-second demo video            |
| **TOTAL**                    | 10.0   |                                                                 |

---

## 📽️ VIDEO DEMO (Required)

- Max duration: **30 seconds**
- Show:
  - Login  
  - Adding item with file/image upload  
  - Viewing the item  
  - Deleting the item  

---

## 📄 README.md INSTRUCTIONS

Your `README.md` must:

- Include this entire exam  
- **Highlight your selected answers in bold** using `**`  

### ✅ Example:
```markdown
2. What is PHP?  
   - a) A styling language  
   - **b) A server-side programming language**  
   - c) A text editor  
   - d) A web server  
```

---

## 📤 HOW TO COPY THIS EXAM INTO YOUR README

> ✨ Follow these steps to copy this entire exam into your `README.md` file:

**Scroll up → Click the "Raw" button → Press Ctrl + A → Ctrl + C (copy the content) → Paste into your `README.md` file**


Sure! Here's the **final notice** to include at the bottom of your exam document, in **English**, with clear and direct instructions:

---

### ⚠️ FINAL NOTICE

If you **publish your project online**, for example using **AWS EC2**, **Vercel**, or any **public hosting service**,  
you **do NOT need** to:

- Record the video demo  
- Create a GitHub repository  

✅ In this case, you only need to **send me the link** to your live project so I can test it directly.

---

### 📤 SUBMISSION IS MANDATORY (Omnivox LEA)

Whether you choose to host your project online **or** upload it to **GitHub**,  
you **must submit either**:

- The **link to your GitHub repository**  
**OR**  
- The **link to your live project**

📩 No submission = **No grade**

---

### ⏰ IMPORTANT – Read Carefully

Please read the exam instructions thoroughly. Whether you're submitting a **live project** or using **GitHub**,  
a smart strategy is to **create your GitHub repository or EC2 server right at the beginning of the exam**.

📎 Then, **submit your repository link or the public link to your live project (e.g., from EC2) as soon as possible** to avoid any last-minute issues or missing the deadline.

✅ This way, you can focus on developing your project calmly, without the stress of rushing to submit the link at the end of the exam.

Absolutely! Here's a clear and professional version of the **submission format instructions** in English:

---

### 📩 SUBMISSION FORMAT

Create a **`.txt` file** using Notepad (or any text editor) and name it:

```
final-exam.txt
```

Inside this file, paste **one of the following**:

- The **link to your GitHub repository**  
**OR**  
- The **public link to your live project** (e.g., from EC2)

📝 This `.txt` file is what you will submit on the platform (Omnivox / LEA).
